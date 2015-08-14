<?php

namespace Ekyna\Bundle\AdvertisementBundle\Controller;
use Ekyna\Bundle\AdvertisementBundle\Entity\Advert;
use Ekyna\Bundle\CoreBundle\Controller\Controller;
use Ekyna\Bundle\CoreBundle\Modal\Modal;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ExampleController
 * @package Ekyna\Bundle\AdvertisementBundle\Controller
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class ExampleController extends Controller
{
    /**
     * Example index page.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $currentPage = $request->query->get('page', 1);

        $pager = $this
            ->get('ekyna_advertisement.advert.repository')
            ->createFrontPager($currentPage, 12)
        ;

        /** @var \Ekyna\Bundle\AdvertisementBundle\Model\AdvertInterface[] $adverts */
        $adverts = $pager->getCurrentPageResults();

        $response = $this->render('EkynaAdvertisementBundle:Example:index.html.twig', array(
            'pager' => $pager,
            'adverts'  => $adverts,
        ));

        $tags = [Advert::getEntityTagPrefix()];
        foreach ($adverts as $a) {
            $tags[] = $a->getEntityTag();
        }

        return $this->configureSharedCache($response, $tags);
    }

    /**
     * Submit action.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function submitAction(Request $request)
    {
        $isXhr = $request->isXmlHttpRequest();

        $modal = new Modal();
        $modal
            ->setType(Modal::TYPE_PRIMARY)
            ->setButtons(array(
                array(
                    'id' => 'close',
                    'label' => 'ekyna_core.button.close',
                    'icon' => 'glyphicon glyphicon-remove',
                    'cssClass' => 'btn-default',
                )
            ))
        ;

        $event = $this->get('ekyna_advertisement.advert.repository')->createNew();

        $cancelPath = $this->generateUrl('ekyna_advertisement_example_index');
        $formOptions = array(
            'action' => $this->generateUrl('ekyna_advertisement_example_submit'),
            'method' => 'POST',
            'attr' => array('class' => 'form-horizontal'),
        );
        $form = $this->createForm('ekyna_advertisement_submit', $event, $formOptions);
        if (!$isXhr) {
            $form->add('actions', 'form_actions', [
                'buttons' => [
                    'validate' => [
                        'type' => 'submit', 'options' => [
                            'button_class' => 'primary',
                            'label' => 'ekyna_core.button.validate',
                            'attr' => [
                                'icon' => 'ok',
                            ],
                        ],
                    ],
                    'cancel' => [
                        'type' => 'button', 'options' => [
                            'label' => 'ekyna_core.button.cancel',
                            'button_class' => 'default',
                            'as_link' => true,
                            'attr' => [
                                'class' => 'form-cancel-btn',
                                'icon' => 'remove',
                                'href' => $cancelPath,
                            ],
                        ],
                    ],
                ],
            ]);
        }

        $form->handleRequest($request);
        if ($form->isValid()) {
            // TODO use ResourceManager
            $event = $this->get('ekyna_advertisement.advert.operator')->create($event);
            if ($event->hasErrors()) {
                $content = 'ekyna_core.error.operation_failed';
                $type = 'danger';
            } else {
                $content = 'ekyna_advertisement.advert.submit.message.success';
                $type = 'success';
            }
            $this->addFlash($content, $type);

            if ($isXhr) {
                $modal->setContent('');
                return $this->get('ekyna_core.modal')->render($modal);
            }
            return $this->redirect($cancelPath);
        }

        if ($isXhr) {
            $modal
                ->setTitle('ekyna_advertisement.advert.submit.title')
                ->setContent($form->createView())
                ->setVars(array('form_template' => 'EkynaAdvertisementBundle:Example:submit_form.html.twig'))
                ->addButton(array(
                    'id'       => 'submit',
                    'label'    => 'ekyna_core.button.save',
                    'icon'     => 'glyphicon glyphicon-ok',
                    'cssClass' => 'btn-success',
                    'autospin' => true,
                ), true)
            ;
            return $this->get('ekyna_core.modal')->render($modal);
        }

        $response = $this->render('EkynaAdvertisementBundle:Example:submit.html.twig', array(
            'form' => $form->createView(),
        ));

        return $response->setPrivate();
    }

    /**
     * Example detail page.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws NotFoundHttpException
     */
    public function detailAction(Request $request)
    {
        $repo = $this->get('ekyna_advertisement.advert.repository');

        $advert = $repo->findOneBySlug($request->attributes->get('slug'));

        if (null === $advert) {
            throw new NotFoundHttpException('Advert not found.');
        }

        $latest = $repo->findLatest();

        return $this->render('EkynaAdvertisementBundle:Example:detail.html.twig', array(
            'advert' => $advert,
            'latest' => $latest,
        ));

        // TODO Shared cache
    }
}

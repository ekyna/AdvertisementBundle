<?php

namespace Ekyna\Bundle\AdvertisementBundle\Controller;
use Ekyna\Bundle\AdvertisementBundle\Entity\Advert;
use Ekyna\Bundle\CoreBundle\Controller\Controller;
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
        $repo = $this->get('ekyna_advertisement.advert.repository');

        $pager = $repo->createPager(
            array('validated' => true),
            array('date' => 'desc')
        );
        $pager
            ->setNormalizeOutOfRangePages(true)
            ->setMaxPerPage(12)
            ->setCurrentPage($currentPage)
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
        $format = $request->isXmlHttpRequest() ? '.xml.twig' : '.html.twig';
        $cancelPath = $this->generateUrl('ekyna_advertisement_example_index');
        $data = [];

        $advert = $this->get('ekyna_advertisement.advert.repository')->createNew();

        $form = $this->createForm('ekyna_advertisement_submit', $advert, array(
            '_footer' => array(
                'buttons' => array(
                    'submit' => array(
                        'theme' => 'primary',
                        'icon'  => 'ok',
                        'label' => 'ekyna_core.button.validate',
                    ),
                ),
                'cancel_path' => $cancelPath,
            ),
        ));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $operator = $this->get('ekyna_advertisement.advert.operator');
            $event = $operator->create($advert);
            if (!$event->hasErrors()) {
                if ($request->isXmlHttpRequest()) {
                    $data['result'] = sprintf(
                        '<div class="alert alert-success"><p>%s</p></div>',
                        $this->getTranslator()->trans('ekyna_advertisement.advert.submit.message.success')
                    );
                } else {
                    $this->addFlash('ekyna_advertisement.advert.submit.message.success', 'success');
                    return $this->redirect($cancelPath);
                }
            }
        }

        if (empty($data)) {
            $data['title'] = 'ekyna_advertisement.advert.submit.title';
            $data['form'] = $form->createView();
        }

        $response = $this->render('EkynaAdvertisementBundle:Example:submit'.$format, $data);

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

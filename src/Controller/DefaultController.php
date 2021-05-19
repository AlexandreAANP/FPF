<?php

namespace App\Controller;

use App\Controller\Forms\FormsController;
use App\Controller\SiteCacheController;
use App\Controller\Product\ProductHighlightedController as ProductHighlighted;
use App\Entity\SiteAccess;
use App\Service\SettingsService;
use Doctrine\DBAL\DBALException;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;

class DefaultController extends SiteCacheController
{
    private $twig;

    public function __construct(EntityManagerInterface $em, ContainerBagInterface $params, RequestStack $requestStack, SessionInterface $session, SettingsService $objSettingsService, Environment $twig)
    {
        $this->twig = $twig;
        parent::__construct($em, $params, $requestStack, $session, $objSettingsService);
    }

    /**
     * @Route("/{category_selected}", name="frontoffice_index", methods={"GET"})
     */
    public function index(Request $request, $category_selected = 'category-home')
    {
        $this->setCacheFilename('home');
        $defaultLanguage = $request->getLocale();

      
     
        /*Restoration*/
        $colBodyHeader = [];
         $url = $this->apiUrl . '/api/content?category=files-category-home&area=content-area-business-header&type=files&fields=url,text,filename&language=' . $defaultLanguage;
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $colBodyHeader = $objData['colContent'];
                }
            }
        }
        $colBodyindex = [];
         $url = $this->apiUrl . '/api/content?category=files-category-home&area=content-area-business-index&type=files&fields=url,text,filename&language=' . $defaultLanguage;
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $colBodyindex = $objData['colContent'];
                }
            }
        }
        $colRestoration = ['header' => $colBodyHeader, 'body' => $colBodyindex];
        /*/Restoration*/
        /*Retail*/
             $colBodyHeader = [];
         $url = $this->apiUrl . '/api/content?category=files-category-home&area=content-area-retail-header&type=files&fields=url,text,filename&language=' . $defaultLanguage;
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $colBodyHeader = $objData['colContent'];
                }
            }
        }
        $colBodyindex = [];
         $url = $this->apiUrl . '/api/content?category=files-category-home&area=content-area-retail-index&type=files&fields=url,text,filename&language=' . $defaultLanguage;
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $colBodyindex = $objData['colContent'];
                }
            }
        }

          $colRetail = ['header' => $colBodyHeader ?? null, 'body' => $colBodyindex ?? null];
          /*/Retail*/
        /*Services*/
         $colBodyHeader = [];
         $url = $this->apiUrl . '/api/content?category=files-category-home&area=content-area-services-header&type=files&fields=url,text,filename&language=' . $defaultLanguage;
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $colBodyHeader = $objData['colContent'];
                }
            }
        }
        $colBodyindex = [];
         $url = $this->apiUrl . '/api/content?category=files-category-home&area=content-area-services-index&type=files&fields=url,text,filename&language=' . $defaultLanguage;
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $colBodyindex = $objData['colContent'];
                }
            }
        }
        $colServices = ['header' => $colBodyHeader ?? null, 'body' => $colBodyindex ?? null];
        /*/Services*/
              /*Mobile*/
         $colBodyHeader = [];
         $url = $this->apiUrl . '/api/content?category=files-category-home&area=content-area-mobile-header&type=files&fields=url,text,filename&language=' . $defaultLanguage;
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $colBodyHeader = $objData['colContent'];
                }
            }
        }
        $colBodyindex = [];
         $url = $this->apiUrl . '/api/content?category=files-category-home&area=content-area-mobile-index&type=files&fields=url,text,filename&language=' . $defaultLanguage;
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $colBodyindex = $objData['colContent'];
                }
            }
        }
        $colMobile = ['header' => $colBodyHeader ?? null, 'body' => $colBodyindex ?? null];
        /*/Mobile*/

              /*Health*/
         $colBodyHeader = [];
         $url = $this->apiUrl . '/api/content?category=files-category-home&area=content-area-health-header&type=files&fields=url,text,filename&language=' . $defaultLanguage;
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $colBodyHeader = $objData['colContent'];
                }
            }
        }
        $colBodyindex = [];
         $url = $this->apiUrl . '/api/content?category=files-category-home&area=content-area-health-index&type=files&fields=url,text,filename&language=' . $defaultLanguage;
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $colBodyindex = $objData['colContent'];
                }
            }
        }
        $colHealth = ['header' => $colBodyHeader ?? null, 'body' => $colBodyindex ?? null];
        /*/Health*/



        /*DOUBTS*/
        $colDoubts=[];
          $url = $this->apiUrl . '/api/content?area=content-area-all-pages&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $colDoubts = $objData['colContent'];
                }
            }
        }
        /*/DOUBTS*/



        /*HOME*/
        if($category_selected === 'category-home' || $category_selected === 'pt' || $category_selected === 'en'){

               /*Banner*/
            $colBanner = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-home&area=content-area-page-header&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colBanner = $objData['colContent'];
                    }
                }
            }
            /*/Banner*/

            /*Footer*/
            $colFooter = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-home&area=content-area-page-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colFooter = $objData['colContent'];
                    }
                }
            }
            /*/Footer*/
             /*Footer Down*/
            $colFooterDown = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-home&area=content-area-footer-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colFooterDown = $objData['colContent'];
                    }
                }
            }
            /*/Footer Down*/


        /*Witnesses*/
            $Witnesses = [];
         $url = $this->apiUrl . '/api/content?category=files-category-home&area=content-area-witnesses&type=files&fields=url,text,filename&language=' . $defaultLanguage;
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $Witnesses = $objData['colContent'];
                }
            }
        }
        foreach ($Witnesses as $value) {
            if(array_key_exists('referenceKey', $value) && $value['referenceKey']=='files-left-card'){
                $leftCard = $value;
            }
            if(array_key_exists('referenceKey', $value) && $value['referenceKey']=='files-right-card'){
                $rightCard = $value;
            }
            if(array_key_exists('referenceKey', $value) && $value['referenceKey']=='files-main-card'){
                $mainCard = $value;
            }
        }
        $colWitnesses = ['leftCard' => $leftCard ?? null, 'rightCard' => $rightCard ?? null, 'mainCard' => $mainCard ?? null];
        /*/Witnesses*/


            return $this->renderSite('index.html.twig', [
            'colBanner' => $colBanner,
            'colFooter' =>$colFooter,
            'colFooterDown' => $colFooterDown,
            'colRestoration' => $colRestoration,
            'colRetail' => $colRetail,
            'colServices' => $colServices,
            'colMobile' => $colMobile,
            'colHealth' => $colHealth,
            'colWitnesses' => $colWitnesses
        ]);
        }







        /*CUSTOMER-SUPPORT*/
        if($category_selected==='customer-support' || $category_selected==='suporte-tecnico'){


              /*Content*/
            $colContent = [];
            $url = $this->apiUrl . '/api/content?category=files-category-customer-support&area=content-area-support-so&type=files&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colContent = $objData['colContent'];
                    }
                }
            }
            /*/Content*/


              /*Banner*/
            $colBanner = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-customer-support&area=content-area-page-header&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colBanner = $objData['colContent'];
                    }
                }
            }
            /*/Banner*/
                /*Footer*/
            $colFooter = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-customer-support&area=content-area-page-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colFooter = $objData['colContent'];
                    }
                }
            }
            /*/Footer*/
            /*Footer Down*/
            $colFooterDown = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-customer-support&area=content-area-footer-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colFooterDown = $objData['colContent'];
                    }
                }
            }
            /*/Footer Down*/
  
            return $this->renderSite('customer_support/index.html.twig',[
                'colContent' => $colContent,
                'colDoubts' => $colDoubts,
                'colBanner' =>$colBanner,
                'colFooter' =>$colFooter,
                'colFooterDown' => $colFooterDown,
             'colRestoration' => $colRestoration,
                'colRetail' => $colRetail,
                'colServices' => $colServices,
                'colMobile' => $colMobile,
                'colHealth' => $colHealth
            ]);

    }



        /*RESTAURANTES*/
        if($category_selected === 'restaurantes' || $category_selected === 'restaurants'){
            /*Artigos*/
            /*/Artigos*/
            $colContent = [];
                $url = $this->apiUrl . '/api/content?category=articles-category-restaurants&type=articles&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colContent = $objData['colContent'];
                        $colContent = $this->organizeArticles($objData['colContent']);
                    }
                }
            }
          
            /*/Content*/


              /*Banner*/
            $colBanner = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-restaurants&area=content-area-page-header&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colBanner = $objData['colContent'];
                    }
                }
            }

            /*/Banner*/
                /*Footer*/
            $colFooter = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-home&area=content-area-page-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colFooter = $objData['colContent'];
                    }
                }
            }
            /*/Footer*/
            /*Footer Down*/
            $colFooterDown = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-home&area=content-area-footer-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colFooterDown = $objData['colContent'];
                    }
                }
            }
            /*/Footer Down*/

            return $this->renderSite('business_areas/restaurants.html.twig',[
                'colContent' => $colContent,
                'colDoubts' => $colDoubts,
                'colBanner' =>$colBanner,
                'colFooter' =>$colFooter,
                'colFooterDown' => $colFooterDown,
                'colRestoration' => $colRestoration,
                'colRetail' => $colRetail,
                'colServices' => $colServices,
                'colMobile' => $colMobile,
                'colHealth' => $colHealth
        ]);

        }
        /*/RESTAURANETS*/





        /*LOJAS*/

        if($category_selected === 'lojas-de-roupa' || $category_selected === 'clothing-store'){
            /*Artigos*/
            /*/Artigos*/
            $colContent = [];
                $url = $this->apiUrl . '/api/content?category=articles-category-clothing-store&type=articles&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colContent = $objData['colContent'];
                        $colContent = $this->organizeArticles($objData['colContent']);
                    }
                }
            }
            /*/Content*/


              /*Banner*/
            $colBanner = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-clothing-store&area=content-area-page-header&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colBanner = $objData['colContent'];
                    }
                }
            }

            /*/Banner*/
                /*Footer*/
            $colFooter = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-clothing-store&area=content-area-page-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colFooter = $objData['colContent'];
                    }
                }
            }
            /*/Footer*/
            /*Footer Down*/
            $colFooterDown = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-clothing-store&area=content-area-footer-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colFooterDown = $objData['colContent'];
                    }
                }
            }
            /*/Footer Down*/

            return $this->renderSite('business_areas/clothing-store.html.twig',[
                'colContent' => $colContent,
                'colDoubts' => $colDoubts,
                'colBanner' =>$colBanner,
                'colFooter' =>$colFooter,
                'colFooterDown' => $colFooterDown,
                'colRestoration' => $colRestoration,
                'colRetail' => $colRetail,
                'colServices' => $colServices,
                'colMobile' => $colMobile,
                'colHealth' => $colHealth
        ]);

        }



        /*/LOJAS*/




        /*CANALIZADORES*/



        if($category_selected === 'canalizadores' || $category_selected === 'plumbers'){
            /*Artigos*/
            /*/Artigos*/
            $colContent = [];
                $url = $this->apiUrl . '/api/content?category=articles-category-plumbers&type=articles&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colContent = $objData['colContent'];
                        $colContent = $this->organizeArticles($objData['colContent']);
                    }
                }
            }
            /*/Content*/


              /*Banner*/
            $colBanner = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-plumbers&area=content-area-page-header&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colBanner = $objData['colContent'];
                    }
                }
            }

            /*/Banner*/
                /*Footer*/
            $colFooter = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-plumbers&area=content-area-page-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colFooter = $objData['colContent'];
                    }
                }
            }
            /*/Footer*/
            /*Footer Down*/
            $colFooterDown = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-plumbers&area=content-area-footer-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colFooterDown = $objData['colContent'];
                    }
                }
            }
            /*/Footer Down*/

            return $this->renderSite('business_areas/plumbers.html.twig',[
                'colContent' => $colContent,
                'colDoubts' => $colDoubts,
                'colBanner' =>$colBanner,
                'colFooter' =>$colFooter,
                'colFooterDown' => $colFooterDown,
                'colRestoration' => $colRestoration,
                'colRetail' => $colRetail,
                'colServices' => $colServices,
                'colMobile' => $colMobile,
                'colHealth' => $colHealth
        ]);

        }
        /*/CANALIZADORES*/
        


        /*TAXIS*/

          if($category_selected === 'taxis' || $category_selected === 'taxi'){
            /*Artigos*/
            /*/Artigos*/
            $colContent = [];
                $url = $this->apiUrl . '/api/content?category=articles-category-taxis&type=articles&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colContent = $objData['colContent'];
                        $colContent = $this->organizeArticles($objData['colContent']);
                    }
                }
            }
            /*/Content*/


              /*Banner*/
            $colBanner = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-taxis&area=content-area-page-header&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colBanner = $objData['colContent'];
                    }
                }
            }

            /*/Banner*/
                /*Footer*/
            $colFooter = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-taxis&area=content-area-page-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colFooter = $objData['colContent'];
                    }
                }
            }
            /*/Footer*/
            /*Footer Down*/
            $colFooterDown = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-taxis&area=content-area-footer-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colFooterDown = $objData['colContent'];
                    }
                }
            }
            /*/Footer Down*/

            return $this->renderSite('business_areas/taxis.html.twig',[
                'colContent' => $colContent,
                'colDoubts' => $colDoubts,
                'colBanner' =>$colBanner,
                'colFooter' =>$colFooter,
                'colFooterDown' => $colFooterDown,
                'colRestoration' => $colRestoration,
                'colRetail' => $colRetail,
                'colServices' => $colServices,
                'colMobile' => $colMobile,
                'colHealth' => $colHealth
        ]);

        }
        /*/TAXIS*/




        /*ABOUT-US*/
          if($category_selected === 'about-us' || $category_selected === 'sobre-nos'){
            /*Artigos*/
            /*/Artigos*/
            $colContent = [];
                $url = $this->apiUrl . '/api/content?category=articles-category-about-us&type=articles&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colContent = $objData['colContent'];
                        $colContent = $this->organizeArticles($objData['colContent']);
                    }
                }
            }
            /*/Content*/


              /*Banner*/
            $colBanner = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-about-us&area=content-area-page-header&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colBanner = $objData['colContent'];
                    }
                }
            }

            /*/Banner*/
                /*Footer*/
            $colFooter = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-home&area=content-area-page-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colFooter = $objData['colContent'];
                    }
                }
            }
            /*/Footer*/
            /*Footer Down*/
            $colFooterDown = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-home&area=content-area-footer-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colFooterDown = $objData['colContent'];
                    }
                }
            }
            /*/Footer Down*/

            return $this->renderSite('about_us/about-us.html.twig',[
                'colContent' => $colContent,
                'colDoubts' => $colDoubts,
                'colBanner' =>$colBanner,
                'colFooter' =>$colFooter,
                'colFooterDown' => $colFooterDown,
                'colRestoration' => $colRestoration,
                'colRetail' => $colRetail,
                'colServices' => $colServices,
                'colMobile' => $colMobile,
                'colHealth' => $colHealth
        ]);

        }
        /*/ABOUT-US*/
    }

    public function organizeArticles($data){

                    $row = [];
                    $info = [];
                    $lines = ['first-row', 'second-row', 'third-row', 'fourth-row', 'fifth-row', 'sixth-row', 'seventh-row', 'eighth-row', 'ninth-row', 'tenth-row', 'eleventh-row', 'twelfth-row'];

                    foreach ($lines as $value) {
                        $row[$value]['text'] = [];
                        $row[$value]['icon'] = [];
                        $row[$value]['image'] = [];
                    }
                    foreach ($data as $value) {
                        for ($i=0; $i < count($lines); $i++) {
                            if(array_key_exists('title', $value) && strpos($value['title'], $lines[$i])!==false){
                                    
                                        if(array_key_exists('description', $value) && strpos($value['description'], 'text') !== false ){
                                             array_push($row[$lines[$i]]['text'], $value['text']);

                                        }
                                        if(array_key_exists('description', $value) && strpos($value['description'], 'icon') !== false ){
                                             array_push($row[$lines[$i]]['icon'], $value['url']);
                                        }
                                        if(array_key_exists('description', $value) && strpos($value['description'], 'image') !== false ){
                                             array_push($row[$lines[$i]]['image'], $value['filename']);

                                        }
                            }
                        }
                    }
                    return $row;
    }



    /**
     * @Route("/cookieConsent", name="frontoffice_cookie_consent", methods={"POST"})
     */
    public function cookieConsent()
    {
        $appVersionFrontOffice = $this->objSettingsService->getEnvVars('APP_VERSION_FRONTOFFICE');

        $date = $this->getDate('now');
        $content = 'Privacy Policy ID: ' . $appVersionFrontOffice . ' | Agreed in ' . $date;

        $objCookieConsentController = new CookieConsentController();
        $objCookieConsentController->setConsent($this->em, $this->domainName, $appVersionFrontOffice, $this->appVersionCookiePolicy);

        $cookie = new Cookie('cookie-consent-' . $this->appVersionCookiePolicy, $content, strtotime('now + 1 year'));

        $response = new Response();
        $response->headers->setCookie($cookie);

        $response->setContent(json_encode([
            'gtmHead' => $this->twig->render('_includes/gtm_head.html.twig'),
            'gtmBody' => $this->twig->render('_includes/gtm_body.html.twig')
        ]));

        $response->headers->set('Content-Type', 'application/json');
        $response->send();
        exit();
    }

    /**
     * @Route("/getAPI", name="frontoffice_get_api", methods={"POST"})
     */
    public function getAPI(Request $request)
    {
        $url = $request->request->get('url');
        $return = [];
        if ($data = $this->getAPIData($this->apiUrl . '/api/' . $url)) {
            $return = json_decode($data, JSON_UNESCAPED_UNICODE);
        }
        if (!array_key_exists('return', $return)) {
            $return['return'] = 'success';
        }
        return $this->json($return);
    }
}
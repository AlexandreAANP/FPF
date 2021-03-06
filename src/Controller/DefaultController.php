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


    public function OrganizeItens($data){
        $itensOrganize['Health-body'] = [];
        $itensOrganize['Mobile-body'] = [];
        $itensOrganize['Services-body'] = [];
        $itensOrganize['Retail-body'] = [];
        $itensOrganize['Restoration-body'] = [];

        foreach ($data as $value) {
            if(array_key_exists('colContentArea', $value) && $value['colContentArea'][0]['name'] === 'Health-header' ){
                            $itensOrganize['Health-header'] = $value;
            }
            if(array_key_exists('colContentArea', $value) && $value['colContentArea'][0]['name'] ==='Health-index' ){ 

                            array_push($itensOrganize['Health-body'], $value);
            }

            if(array_key_exists('colContentArea', $value) && $value['colContentArea'][0]['name'] === 'Mobile-header' ){
                            $itensOrganize['Mobile-header'] = $value;
            }
            if(array_key_exists('colContentArea', $value) && $value['colContentArea'][0]['name'] ==='Mobile-index' ){ 

                            array_push($itensOrganize['Mobile-body'], $value);
            }

            if(array_key_exists('colContentArea', $value) && $value['colContentArea'][0]['name'] === 'Services-header' ){
                            $itensOrganize['Services-header'] = $value;
            }
            if(array_key_exists('colContentArea', $value) && $value['colContentArea'][0]['name'] ==='Services-index' ){ 

                            array_push($itensOrganize['Services-body'], $value);
            }

            if(array_key_exists('colContentArea', $value) && $value['colContentArea'][0]['name'] === 'Retail-header' ){
                            $itensOrganize['Retail-header'] = $value;
            }
            if(array_key_exists('colContentArea', $value) && $value['colContentArea'][0]['name'] ==='Retail-index' ){ 

                            array_push($itensOrganize['Retail-body'], $value);
            }


            if(array_key_exists('colContentArea', $value) && $value['colContentArea'][0]['name'] === 'Restoration-header' ){
                            $itensOrganize['Restoration-header'] = $value;
            }
            if(array_key_exists('colContentArea', $value) && $value['colContentArea'][0]['name'] ==='Restoration-index' ){ 

                            array_push($itensOrganize['Restoration-body'], $value);
            }
        }
        return $itensOrganize;
    }

    /**
     * @Route("/", name="frontoffice_index", methods={"GET"})
     */
    public function index(Request $request, $category_selected = 'category-home', $item=null)
    {   

        $this->setCacheFilename('home');
        $defaultLanguage = $request->getLocale();

        $allItens = [];
        
           $url = $this->apiUrl . '/api/content?category=files-category-home&type=files&fields=url,text,filename,area&language=' . $defaultLanguage;
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $allItens = $this->OrganizeItens($objData['colContent']);

                }
            }
        }



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
            'allItens' => $allItens,
            'colBanner' => $colBanner,
            'colDoubts' => $colDoubts,
            'colFooter' =>$colFooter,
            'colFooterDown' => $colFooterDown,
            'colWitnesses' => $colWitnesses
        ]);


    }


      /**
     * @Route("/Event/{EventName}", name="frontoffice_event", methods={"GET"})
     */
    
      public function Event (Request $request, $EventName = null){
        $this->setCacheFilename('home');
        $defaultLanguage = $request->getLocale();

    

           /*Banner*/
            $colBanner = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-event&area=content-area-page-header&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colBanner = $objData['colContent'];
                    }
                }
            }
            /*/Banner*/


            /*Check name of event exist*/
            $referenceKeyOfEvent = null;
            if($EventName){    
                $colContent = [];
                $url = $this->apiUrl . '/api/content?category=events-category-events&fields=url,text,filename,area&language=' . $defaultLanguage;
                if ($data = $this->getAPIData($url)) {
                    if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                        if (array_key_exists('colContent', $objData)) {
                            $colContent = $objData['colContent'];
                            foreach ($colContent as $value) {
                                foreach ($value['colContentArea'] as $value1) {
                                    if(strtolower($value1['name'])===strtolower($EventName)){
                                        $referenceKeyOfEvent = $value1['referenceKey'];
                                        break;
                                    }
                                }
                                if($referenceKeyOfEvent){
                                    break;
                                }
                            }
                        }
                    }
                }
            }



            if($referenceKeyOfEvent){
            /*Content*/
            $colContent = [];
            $url = $this->apiUrl . '/api/content?category=events-category-events&area='.$referenceKeyOfEvent.'&fields=url,text,filename,area&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $col = $objData['colContent'];
                        foreach ($col as $key => $value) {
                            if(strpos($value['description'], "plus-information") !== false){
                                if(strpos($value['description'], "1")){
                                    $colContent[intval($value['url'])][0] = $value;    
                                }
                                elseif(strpos($value['description'], "2")){
                                    $colContent[intval($value['url'])][1] = $value;   
                                }
                            }
                            else{
                                $colContent[intval($value['url'])] = $value;    
                            }
                            
                        }
                        ksort($colContent);
                    }
                }
            }
            /*/Content*/
            }
            else{
                $Eventlist=[];
                $url = $this->apiUrl . '/api/content?category=events-category-footer&type=events&fields=url,text,filename&language=' . $defaultLanguage;
                if ($data = $this->getAPIData($url)) {
                    if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                        if (array_key_exists('colContent', $objData)) {
                            $Eventlist = $objData['colContent'];
                        }
                    }
                }

             
                return $this->renderSite('Event/events_list.html.twig',[
                    'colBanner'         => $colBanner,
                    'Eventlist'              => $Eventlist
                ]);
            }
            
            //dd($colContent);
            return $this->renderSite('Event/index.html.twig',[
                'colBanner'         => $colBanner,
                'colContent'        => $colContent,
                'event'             => $EventName
            ]);
      }




      /**
      * @Route("/return-policy", name="frontoffice_returnPolicy", methods={"GET"})
      */

      public function returnPolicy(Request $request){

          $this->setCacheFilename('home');
        $defaultLanguage = $request->getLocale();

    

           /*Banner*/
            $colBanner = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-privacy-policy&area=content-area-page-header&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colBanner = $objData['colContent'];
                    }
                }
            }
            /*/Banner*/



           /*Content*/
            $colContent = [];
            $url = $this->apiUrl . '/api/content?area=content-area-store&type=privacy-policy&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colContent = $objData['colContent'];
                        foreach ($colContent as $key => $value) {
                            if($value['referenceKey']==="privacy-policy-return-policy"){
                                $colContent = $value;
                            }
                        }
                    }
                }
            }
            /*/Content*/
            return $this->renderSite('privacy-policy/return-policy.html.twig',[
                'colBanner'             => $colBanner,
                'colContent'            => $colContent,
            ]);
      }



      /**
      * @Route("/privacy-delivery-policy", name="frontoffice_deliveryPolicy", methods={"GET"})
      */

      public function deliveryPolicy(Request $request){

          $this->setCacheFilename('home');
        $defaultLanguage = $request->getLocale();

    

           /*Banner*/
            $colBanner = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-privacy-policy&area=content-area-page-header&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colBanner = $objData['colContent'];
                    }
                }
            }
            /*/Banner*/



           /*Content*/
            $colContent = [];
            $url = $this->apiUrl . '/api/content?area=content-area-store&type=privacy-policy&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colContent = $objData['colContent'];
                        foreach ($colContent as $key => $value) {
                            if($value['referenceKey']==="privacy-policy-delivery-policy"){
                                $colContent = $value;
                            }
                        }
                    }
                }
            }
            /*/Content*/
            return $this->renderSite('privacy-policy/return-policy.html.twig',[
                'colBanner'             => $colBanner,
                'colContent'            => $colContent,
            ]);
      }



     /**
     * @Route("/litigation", name="frontoffice_litigation", methods={"GET"})
     * @Route("/litigios", name="frontoffice_litigios", methods={"GET"})
     */

     public function Litigation (Request $request){
        
        $this->setCacheFilename('home');
        $defaultLanguage = $request->getLocale();


           /*Banner*/
            $colBanner = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-litigation&area=content-area-page-header&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colBanner = $objData['colContent'];
                    }
                }
            }
            /*/Banner*/

         /*content*/
            $colContent = [];
            $url = $this->apiUrl . '/api/content?type=terms&category=terms-category-litigation&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colContent = $objData['colContent'];
                    }
                }
            }
            /*/content*/

              return $this->renderSite('terms/litigation.html.twig',[
                'colBanner' =>$colBanner,
                'colContent' => $colContent
            ]);


    }


    /**
     * @Route("/SLA", name="frontoffice_sla", methods={"GET"})
     */

     public function SLA(Request $request){
        
        $this->setCacheFilename('home');
        $defaultLanguage = $request->getLocale();

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

           /*Banner*/
            $colBanner = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-sla&area=content-area-page-header&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colBanner = $objData['colContent'];
                    }
                }
            }
            /*/Banner*/

         /*content*/
            $colContent = [];
            $url = $this->apiUrl . '/api/content?type=terms&category=terms-category-sla&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colContent = $objData['colContent'];
                        $content = [];
                        foreach ($colContent as $key => $value) {
                            $content[intval($value['url'])] = $value;
                        }
                        ksort($content);
                        $colContent=$content;
                    }
                }
            }
            /*/content*/

              return $this->renderSite('terms/SLA.html.twig',[
                'colBanner' =>$colBanner,
                'colDoubts' => $colDoubts,
                'colContent' => $colContent
            ]);


    }


     /**
     * @Route("/privacy-policy", name="frontoffice_privacy-policy", methods={"GET"})
     * @Route("/politica-de-privacidade", name="frontoffice_politica-privacidade", methods={"GET"})
     */

     public function PrivacyPolicy (Request $request){
        
        $this->setCacheFilename('home');
        $defaultLanguage = $request->getLocale();

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

           /*Banner*/
            $colBanner = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-privacy-policy&area=content-area-page-header&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colBanner = $objData['colContent'];
                    }
                }
            }
            /*/Banner*/

            /*content*/
            $colContent = [];
            $url = $this->apiUrl . '/api/content?type=privacy-policy&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colContent = $objData['colContent'];
                        $content = [];
                        foreach ($colContent as $key => $value) {
                            if($value['description']=='fpf_sistemas'){
                                $content[intval($value['url'])] = $value;
                            }
                        }
                        ksort($content);
                        $colContent=$content;
                    }
                }
            }

            /*/content*/
              return $this->renderSite('privacy-policy/index.html.twig',[
                'colBanner' =>$colBanner,
                'colDoubts' => $colDoubts,
                'colContent' => $colContent
            ]);
     }

    
    /**
     * @Route("/customer-support", name="frontoffice_customer-support", methods={"GET"})
     * @Route("/suporte-tecnico", name="frontoffice_suporte-tecnico", methods={"GET"})
     */

    public function CustomerSupport (Request $request) {
         $this->setCacheFilename('home');
        $defaultLanguage = $request->getLocale();

        $allItens = [];
        
           $url = $this->apiUrl . '/api/content?category=files-category-home&type=files&fields=url,text,filename,area&language=' . $defaultLanguage;
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $allItens = $this->OrganizeItens($objData['colContent']);

                }
            }
        }



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
                'allItens' => $allItens,
                'colDoubts' => $colDoubts,
                'colBanner' =>$colBanner,
                'colFooter' =>$colFooter,
                'colFooterDown' => $colFooterDown
            ]);

    }

    /**
     * @Route("/who-we-are", name="frontoffice_about-us", methods={"GET"})
     * @Route("/quem-somos", name="frontoffice_sobre-nos", methods={"GET"})
     */
    public function AboutUs(Request $request, $item = null){
           $this->setCacheFilename('home');
        $defaultLanguage = $request->getLocale();


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
         $colContent = [];
            $data = [];
                $url = $this->apiUrl . '/api/content?category=articles-category-who-we-are&type=articles&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $data = $objData['colContent'];
                      
                        $articles = [];
                        $logo = null;
                       
                        foreach ($data as $value) {
                            if($value['url'] === 'logo' ){
                                $logo = $value;
                            }
                            if($value['url'] !== '' && $value['url'] !== 'logo'){
                                $articles[intval($value['url'])][intval($value['description'])] = $value;
                            }
                         }
                         foreach ($articles as $key => $value) {
                                ksort($articles[$key]);
                         }
                        ksort($articles);
                        $colContent["articles"] = $articles;
                        $colContent["logo"] = $logo;
                     
                       /* foreach ($data as $value) {
                            if(array_key_exists('referenceKey', $value) && $value['referenceKey']==='articles-about-us-logo'){
                                $colContent['image']= $value['filename'];
                            } 
                            if(array_key_exists('referenceKey', $value) && $value['referenceKey']==='articles-about-us-text-1'){
                                $colContent['text-1']=$value['text'];
                            }
                            if(array_key_exists('referenceKey', $value) && $value['referenceKey']==='articles-about-us-text-2'){
                                $colContent['text-2']=$value['text'];
                            }
                        }*/
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
                'colFooterDown' => $colFooterDown
        ]);

    }



    /**
     * @Route("/restoration/{item}", name="frontoffice_restoration", methods={"GET"})
     * @Route("/restauracao/{item}", name="frontoffice_restauracao", methods={"GET"})   
     * @Route("/restaura????o/{item}", name="frontoffice_restaura????o", methods={"GET"})  
     */
    public function Restoration(Request $request, $item = null){

        $this->setCacheFilename('home');
        $defaultLanguage = $request->getLocale();

        $allItensEn = [];
        
           $url = $this->apiUrl . '/api/content?category=files-category-home&type=files&fields=url,text,filename,area&language=en';
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $allItensEn = $this->OrganizeItens($objData['colContent']);

                }
            }
        }
        $allItensPt = [];
             $url = $this->apiUrl . '/api/content?category=files-category-home&type=files&fields=url,text,filename,area&language=pt';
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $allItensPt = $this->OrganizeItens($objData['colContent']);

                }
            }
        }




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


         /*Item*/
            if($item){
                $item= strtolower($item);
                //dd($defaultLanguage);
                    $itemPt = null;
                    $itemEn = null;
                    foreach ($allItensEn['Restoration-body'] as $value) {
                        if(array_key_exists('title', $value) && strtolower($value['title'])===$item){
                            $item=$value['referenceKey'];
                        }
                    }
                    
                    if(!$itemEn){
                         foreach ($allItensPt['Restoration-body'] as $key => $value) {
                             if(array_key_exists('title', $value) && strtolower($value['title'])===$item){

                                $item=$value['referenceKey'];
                            }
                        }
                    }

                    if($item && $defaultLanguage=='en'){
                        foreach ($allItensEn['Restoration-body'] as $key => $value) {
                            if(array_key_exists('referenceKey', $value) && $value['referenceKey'] === $item){
                                $item = $value;
                                break;
                            }
                        }
                    }
                    elseif($item && $defaultLanguage=='pt'){
                     
                         foreach ($allItensPt['Restoration-body'] as $key => $value) {
                            if(array_key_exists('referenceKey', $value) && $value['referenceKey'] === $item){
                                $item = $value;
                                break;
                            }
                        }
                    }
                    elseif(!is_array($item)){
                        if($defaultLanguage=='pt'){
                            $item = $allItensPt['Restoration-body'][0] ?? [];
                        }
                        else{
                            $item = $allItensEn['Restoration-body'][0] ?? [];   
                        }
                    }
            }
            else{
                if($defaultLanguage=='pt'){
                    $item = $allItensPt['Restoration-body'][0] ?? [];
                        }
                else{
                    $item = $allItensEn['Restoration-body'][0] ?? [];   
                        }
            }
            /*Item*/

            /*Artigos*/
            /*/Artigos*/
            $colContent = [];
                $url = $this->apiUrl . '/api/content?category=articles-category-restoration&type=articles&fields=url,text,filename,area&language=' . $defaultLanguage;
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
            $url = $this->apiUrl . '/api/content?category=richmedia-category-restoration&area=content-area-page-header&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
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
            return $this->renderSite('business_areas/restoration.html.twig',[
                'allItens' => $allItensEn,
                'item' => $item,
                'colContent' => $colContent,
                'colDoubts' => $colDoubts,
                'colBanner' =>$colBanner,
                'colFooter' =>$colFooter,
                'colFooterDown' => $colFooterDown
        ]);
    }



     /**
     * @Route("/retail/{item}", name="frontoffice_retail", methods={"GET"})
     * @Route("/retalho/{item}", name="frontoffice_retalho", methods={"GET"})
     */

     public function Retail(Request $request, $item = null){

        $this->setCacheFilename('home');
        $defaultLanguage = $request->getLocale();

            $allItensEn = [];
        
           $url = $this->apiUrl . '/api/content?category=files-category-home&type=files&fields=url,text,filename,area&language=en';
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $allItensEn = $this->OrganizeItens($objData['colContent']);

                }
            }
        }
        $allItensPt = [];
             $url = $this->apiUrl . '/api/content?category=files-category-home&type=files&fields=url,text,filename,area&language=pt';
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $allItensPt = $this->OrganizeItens($objData['colContent']);

                }
            }
        }



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


             /*Item*/
            if($item){
                $item= strtolower($item);
                //dd($defaultLanguage);
                    $itemPt = null;
                    $itemEn = null;
                    foreach ($allItensEn['Retail-body'] as $value) {
                        if(array_key_exists('title', $value) && strtolower($value['title'])===$item){
                            $item=$value['referenceKey'];
                        }
                    }
                    
                    if(!$itemEn){
                         foreach ($allItensPt['Retail-body'] as $key => $value) {
                             if(array_key_exists('title', $value) && strtolower($value['title'])===$item){

                                $item=$value['referenceKey'];
                            }
                        }
                    }

                    if($item && $defaultLanguage=='en'){
                        foreach ($allItensEn['Retail-body'] as $key => $value) {
                            if(array_key_exists('referenceKey', $value) && $value['referenceKey'] === $item){
                                $item = $value;
                                break;
                            }
                        }
                    }
                    elseif($item && $defaultLanguage=='pt'){
                     
                         foreach ($allItensPt['Retail-body'] as $key => $value) {
                            if(array_key_exists('referenceKey', $value) && $value['referenceKey'] === $item){
                                $item = $value;
                                break;
                            }
                        }
                    }
                    elseif(!is_array($item)){
                        if($defaultLanguage=='pt'){
                            $item = $allItensPt['Retail-body'][0] ?? [];
                        }
                        else{
                            $item = $allItensEn['Retail-body'][0] ?? [];   
                        }
                    }
            }
            else{
                if($defaultLanguage=='pt'){
                    $item = $allItensPt['Retail-body'][0] ?? [];
                        }
                else{
                    $item = $allItensEn['Retail-body'][0] ?? [];   
                        }
            }
            /*Item*/


            /*Artigos*/
            /*/Artigos*/
            $colContent = [];
                $url = $this->apiUrl . '/api/content?category=articles-category-retail&type=articles&fields=url,text,filename,area&language=' . $defaultLanguage;
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
            $url = $this->apiUrl . '/api/content?category=richmedia-category-retail&area=content-area-page-header&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
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
            $url = $this->apiUrl . '/api/content?category=richmedia-category-retail&area=content-area-page-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
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
            $url = $this->apiUrl . '/api/content?category=richmedia-category-retail&area=content-area-footer-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colFooterDown = $objData['colContent'];
                    }
                }
            }
            /*/Footer Down*/

            return $this->renderSite('business_areas/retail.html.twig',[
                'item' => $item,
                'allItens' => $allItensEn,
                'colContent' => $colContent,
                'colDoubts' => $colDoubts,
                'colBanner' =>$colBanner,
                'colFooter' =>$colFooter,
                'colFooterDown' => $colFooterDown

            ]);
     }


    /**
     * @Route("/services/{item}", name="frontoffice_services", methods={"GET"})
     * @Route("/servi??os/{item}", name="frontoffice_servi??os", methods={"GET"})
     * @Route("/servicos/{item}", name="frontoffice_servicos", methods={"GET"})
     */

        public function service(Request $request, $item = null){

        $this->setCacheFilename('home');
        $defaultLanguage = $request->getLocale();

                $allItensEn = [];
        
           $url = $this->apiUrl . '/api/content?category=files-category-home&type=files&fields=url,text,filename,area&language=en';
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $allItensEn = $this->OrganizeItens($objData['colContent']);

                }
            }
        }
        $allItensPt = [];
             $url = $this->apiUrl . '/api/content?category=files-category-home&type=files&fields=url,text,filename,area&language=pt';
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $allItensPt = $this->OrganizeItens($objData['colContent']);

                }
            }
        }




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



          /*Item*/
            if($item){
                $item= strtolower($item);
                //dd($defaultLanguage);
                    $itemPt = null;
                    $itemEn = null;
                    foreach ($allItensEn['Services-body'] as $value) {
                        if(array_key_exists('title', $value) && strtolower($value['title'])===$item){
                            $item=$value['referenceKey'];
                        }
                    }
                    
                    if(!$itemEn){
                         foreach ($allItensPt['Services-body'] as $key => $value) {
                             if(array_key_exists('title', $value) && strtolower($value['title'])===$item){

                                $item=$value['referenceKey'];
                            }
                        }
                    }

                    if($item && $defaultLanguage=='en'){
                        foreach ($allItensEn['Services-body'] as $key => $value) {
                            if(array_key_exists('referenceKey', $value) && $value['referenceKey'] === $item){
                                $item = $value;
                                break;
                            }
                        }
                    }
                    elseif($item && $defaultLanguage=='pt'){
                     
                         foreach ($allItensPt['Services-body'] as $key => $value) {
                            if(array_key_exists('referenceKey', $value) && $value['referenceKey'] === $item){
                                $item = $value;
                                break;
                            }
                        }
                    }
                    elseif(!is_array($item)){
                        if($defaultLanguage=='pt'){
                            $item = $allItensPt['Services-body'][0] ?? [];
                        }
                        else{
                            $item = $allItensEn['Services-body'][0] ?? [];   
                        }
                    }
            }
            else{
                if($defaultLanguage=='pt'){
                    $item = $allItensPt['Services-body'][0] ?? [];
                        }
                else{
                    $item = $allItensEn['Services-body'][0] ?? [];   
                        }
            }
            /*Item*/
            /*Artigos*/
            /*/Artigos*/
            $colContent = [];
                $url = $this->apiUrl . '/api/content?category=articles-category-service&type=articles&fields=url,text,filename,area&language=' . $defaultLanguage;
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
            $url = $this->apiUrl . '/api/content?category=richmedia-category-service&area=content-area-page-header&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
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
            $url = $this->apiUrl . '/api/content?category=richmedia-category-service&area=content-area-page-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
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
            $url = $this->apiUrl . '/api/content?category=richmedia-category-service&area=content-area-footer-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colFooterDown = $objData['colContent'];
                    }
                }
            }
            /*/Footer Down*/

            return $this->renderSite('business_areas/services.html.twig',[
                'item' => $item,
                'allItens' => $allItensEn,
                'colContent' => $colContent,
                'colDoubts' => $colDoubts,
                'colBanner' =>$colBanner,
                'colFooter' =>$colFooter,
                'colFooterDown' => $colFooterDown
        ]);


        }


    /**
     * @Route("/Servi??os", name="frontoffice_Servi??os", methods={"GET"})
     * @Route("/Services", name="frontoffice_Services", methods={"GET"})
     */
    public function Services(Request $request, $item = null){
        $this->setCacheFilename('home');
        $defaultLanguage = $request->getLocale();


        $allItens = [];
        
           $url = $this->apiUrl . '/api/content?category=files-category-home&type=files&fields=url,text,filename,area&language=' . $defaultLanguage;
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $allItens = $this->OrganizeItens($objData['colContent']);

                }
            }
        }



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


 /*Item*/
            if($item){
                $item= strtolower($item);
                //dd($defaultLanguage);
                    $itemPt = null;
                    $itemEn = null;
                    foreach ($allItensEn['Services-body'] as $value) {
                        if(array_key_exists('title', $value) && strtolower($value['title'])===$item){
                            $item=$value['referenceKey'];
                        }
                    }
                    
                    if(!$itemEn){
                         foreach ($allItensPt['Services-body'] as $key => $value) {
                             if(array_key_exists('title', $value) && strtolower($value['title'])===$item){

                                $item=$value['referenceKey'];
                            }
                        }
                    }

                    if($item && $defaultLanguage=='en'){
                        foreach ($allItensEn['Services-body'] as $key => $value) {
                            if(array_key_exists('referenceKey', $value) && $value['referenceKey'] === $item){
                                $item = $value;
                                break;
                            }
                        }
                    }
                    elseif($item && $defaultLanguage=='pt'){
                     
                         foreach ($allItensPt['Services-body'] as $key => $value) {
                            if(array_key_exists('referenceKey', $value) && $value['referenceKey'] === $item){
                                $item = $value;
                                break;
                            }
                        }
                    }
                    elseif(!is_array($item)){
                        if($defaultLanguage=='pt'){
                            $item = $allItensPt['Services-body'][0] ?? [];
                        }
                        else{
                            $item = $allItensEn['Services-body'][0] ?? [];   
                        }
                    }
            }
            else{
                if($defaultLanguage=='pt'){
                    $item = $allItensPt['Services-body'][0] ?? [];
                        }
                else{
                    $item = $allItensEn['Services-body'][0] ?? [];   
                        }
            }
            /*Item*/


            /*Content*/
            $Consultoria = [];
                $url = $this->apiUrl . '/api/content?category=articles-category-services&area=content-area-consulting-planning-and-design&type=articles&fields=url,text,filename,area&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $Consultoria = $objData['colContent'];
                        $order = [];
                       foreach ($Consultoria as $key => $value) {
                            $order[$value['url']-1]= $value;
                       }
                       ksort($order);
                       $Consultoria = $order;
                    }
                }
            }
            
           

            $implementacao = [];
                $url = $this->apiUrl . '/api/content?category=articles-category-services&area=content-area-software-implementation&type=articles&fields=url,text,filename,area&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $implementacao = $objData['colContent'];
                         $order = [];
                       foreach ($implementacao as $key => $value) {
                            $order[$value['url']-1]= $value;
                       }
                       ksort($order);
                       $implementacao = $order;
                    }
                }
            }

            $assistencia = [];
                $url = $this->apiUrl . '/api/content?category=articles-category-services&area=content-area-software-assistance&type=articles&fields=url,text,filename,area&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $assistencia = $objData['colContent'];
                        $order = [];
                       foreach ($assistencia as $key => $value) {
                            $order[$value['url']-1]= $value;
                       }
                       ksort($order);
                       $assistencia = $order;
                       
                    }
                }
            }

            $tecnica = [];
                $url = $this->apiUrl . '/api/content?category=articles-category-services&area=content-area-technical-assistance&type=articles&fields=url,text,filename,area&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $tecnica = $objData['colContent'];
                        $order = [];
                       foreach ($tecnica as $key => $value) {
                            $order[$value['url']-1]= $value;
                       }
                       ksort($order);
                       $tecnica = $order;
                       
                    }
                }
            }

             $solutions = [];
                $url = $this->apiUrl . '/api/content?category=articles-category-services&area=content-area-business-solutions&type=articles&fields=url,text,filename,area&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $solutions = $objData['colContent'];
                        $order = [];
                       foreach ($solutions as $key => $value) {
                            $order[$value['url']-1]= $value;
                       }
                       ksort($order);
                       $solutions = $order;
                       
                    }
                }
            }

              $qualidade = [];
                $url = $this->apiUrl . '/api/content?category=articles-category-services&area=content-area-quality&type=articles&fields=url,text,filename,area&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $qualidade = $objData['colContent'];
                        $order = [];
                       foreach ($qualidade as $key => $value) {
                            $order[$value['url']-1]= $value;
                       }
                       ksort($order);
                       $qualidade = $order;
                       
                    }
                }
            }
            /*/Content*/


              /*Banner*/
            $colBanner = [];
            $url = $this->apiUrl . '/api/content?category=richmedia-category-services&area=content-area-page-header&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
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
            $url = $this->apiUrl . '/api/content?category=richmedia-category-services&area=content-area-page-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
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
            $url = $this->apiUrl . '/api/content?category=richmedia-category-service&area=content-area-footer-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colFooterDown = $objData['colContent'];
                    }
                }
            }
            /*/Footer Down*/

            return $this->renderSite('Services/Services.html.twig',[
                'item' => $item,
                'allItens' => $allItens,
                'colConsultoria' => $Consultoria,
                'colImplementacao' => $implementacao,
                'colAssistencia' => $assistencia,
                'colTecnica' => $tecnica,
                'colSolutions' => $solutions,
                'colQualidade' => $qualidade,
                'colDoubts' => $colDoubts,
                'colBanner' =>$colBanner,
                'colFooter' =>$colFooter,
                'colFooterDown' => $colFooterDown
        ]);
    }

    /**
     * @Route("/mobile/{item}", name="frontoffice_mobile", methods={"GET"})
     */

    public function Mobile(Request $request, $item = null){


        $this->setCacheFilename('home');
        $defaultLanguage = $request->getLocale();

               $allItensEn = [];
        
           $url = $this->apiUrl . '/api/content?category=files-category-home&type=files&fields=url,text,filename,area&language=en';
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $allItensEn = $this->OrganizeItens($objData['colContent']);

                }
            }
        }
        $allItensPt = [];
             $url = $this->apiUrl . '/api/content?category=files-category-home&type=files&fields=url,text,filename,area&language=pt';
        if ($data = $this->getAPIData($url)) {
            if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                if (array_key_exists('colContent', $objData)) {
                    $allItensPt = $this->OrganizeItens($objData['colContent']);

                }
            }
        }



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
 /*Item*/
            if($item){
                $item= strtolower($item);
                //dd($defaultLanguage);
                    $itemPt = null;
                    $itemEn = null;
                    foreach ($allItensEn['Mobile-body'] as $value) {
                        if(array_key_exists('title', $value) && strtolower($value['title'])===$item){
                            $item=$value['referenceKey'];
                        }
                    }
                    
                    if(!$itemEn){
                         foreach ($allItensPt['Mobile-body'] as $key => $value) {
                             if(array_key_exists('title', $value) && strtolower($value['title'])===$item){

                                $item=$value['referenceKey'];
                            }
                        }
                    }

                    if($item && $defaultLanguage=='en'){
                        foreach ($allItensEn['Mobile-body'] as $key => $value) {
                            if(array_key_exists('referenceKey', $value) && $value['referenceKey'] === $item){
                                $item = $value;
                                break;
                            }
                        }
                    }
                    elseif($item && $defaultLanguage=='pt'){
                     
                         foreach ($allItensPt['Mobile-body'] as $key => $value) {
                            if(array_key_exists('referenceKey', $value) && $value['referenceKey'] === $item){
                                $item = $value;
                                break;
                            }
                        }
                    }
                    elseif(!is_array($item)){
                        if($defaultLanguage=='pt'){
                            $item = $allItensPt['Mobile-body'][0] ?? [];
                        }
                        else{
                            $item = $allItensEn['Mobile-body'][0] ?? [];   
                        }
                    }
            }
            else{
                if($defaultLanguage=='pt'){
                    $item = $allItensPt['Mobile-body'][0] ?? [];
                        }
                else{
                    $item = $allItensEn['Mobile-body'][0] ?? [];   
                        }
            }
            /*Item*/

            /*Artigos*/
            /*/Artigos*/
            $colContent = [];
                $url = $this->apiUrl . '/api/content?category=articles-category-mobile&type=articles&fields=url,text,filename,area&language=' . $defaultLanguage;
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
            $url = $this->apiUrl . '/api/content?category=richmedia-category-mobile&area=content-area-page-header&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
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
            $url = $this->apiUrl . '/api/content?category=richmedia-category-mobile&area=content-area-page-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
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
            $url = $this->apiUrl . '/api/content?category=richmedia-category-mobile&area=content-area-footer-footer&type=richmedia&fields=url,text,filename&language=' . $defaultLanguage;
            if ($data = $this->getAPIData($url)) {
                if ($objData = json_decode($data, JSON_UNESCAPED_UNICODE)) {
                    if (array_key_exists('colContent', $objData)) {
                        $colFooterDown = $objData['colContent'];
                    }
                }
            }
            /*/Footer Down*/

            return $this->renderSite('business_areas/mobile.html.twig',[
                'item' => $item,
                'allItens' => $allItensEn,
                'colContent' => $colContent,
                'colDoubts' => $colDoubts,
                'colBanner' =>$colBanner,
                'colFooter' =>$colFooter,
                'colFooterDown' => $colFooterDown
        ]);
    }

    private function organizeArticles($data){
                    $row = [];
                    $lines = ['first-row', 'second-row', 'third-row', 'fourth-row', 'fifth-row', 'sixth-row', 'seventh-row', 'eighth-row', 'ninth-row', 'tenth-row', 'eleventh-row', 'twelfth-row'];
                    
                    //Separa os valores da query em linhas, pelo o nome da categoria que se encontra
                    foreach ($data as $value) {
                    
                        if(is_array($value) && array_key_exists('colContentArea', $value) && in_array($value['colContentArea'][0]['name'], $lines)){

                            $row[$value['colContentArea'][0]['name']] [] = $value;

                        }

                    }

                    //separa o tipo
                    foreach ($row as $key => $value) {
                        foreach ($value as $value2) {
                            if(strpos('text',$value2['description'])!==false){
                                $row[$key]['text'] [] = $value2;
                            }
                            elseif(strpos('image',$value2['description'])!==false){
                                $row[$key]['image'] [] = $value2;
                            }
                            elseif(strpos('icon',$value2['description'])!==false){
                                $row[$key]['icon'] [] = $value2;
                            }
                        }
                        foreach($value as $chave => $value2){
                            if(is_numeric($chave)){
                                unset($row[$key][$chave]);
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
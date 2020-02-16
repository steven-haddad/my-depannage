<?php
/**
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    Apply Novation <applynovation@gmail.com>
*  @copyright 2016-2017 Apply Novation
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

$module = $this;
$lineHeight = array('normal', '10px', '11px', '12px', '13px', '14px', '15px', '16px', '17px', '18px', '19px', '20px', '21px', '22px', '23px', '24px', '25px', '26px', '27px', '28px', '29px', '30px', '31px', '32px', '33px', '34px', '35px',
);
$fontSizeSlider = array('10px', '11px', '12px', '13px', '14px', '15px', '16px', '17px', '18px', '19px', '20px', '21px', '22px', '23px', '24px', '25px', '26px', '27px', '28px', '29px', '30px', '31px', '32px', '33px', '34px', '35px', '36px', '37px', '38px', '39px', '40px', '41px', '42px', '43px', '44px', '45px', '46px', '47px', '48px', '49px', '50px', '51px', '52px', '53px', '54px', '55px', '56px', '57px', '58px', '59px', '60px',
);
$fontSizes = array('10px', '11px', '12px', '13px', '14px', '15px', '16px', '17px', '18px', '19px', '20px', '21px', '22px', '23px', '24px', '25px', '26px', '27px', '28px', '29px', '30px', '31px', '32px', '33px', '34px', '35px',
);
$border_radius = array('0px', '1px', '2px', '3px', '4px', '5px', '6px', '7px', '8px', '9px','10px', '11px', '12px', '13px', '14px', '15px', '16px', '17px', '18px', '19px', '20px', '21px', '22px', '23px', '24px', '25px', '26px', '27px', '28px', '29px', '30px', '31px', '32px', '33px', '34px', '35px', '36px', '37px', '38px', '39px', '40px', '41px', '42px', '43px', '44px', '45px', '46px', '47px', '48px', '49px', '50px', '51px', '52px', '53px', '54px', '55px', '56px', '57px', '58px', '59px', '60px',
);
$animationTime = array('100', '200', '300', '400', '500', '600', '700', '800', '900', '1000',
);
$stepSize = array('100', '200', '300', '400', '500', '600', '700', '800', '900','2000',
);
$padding = array( '0px', '1px', '2px', '3px', '4px', '5px', '6px', '7px', '8px', '9px','10px', '11px', '12px', '13px', '14px', '15px', '16px', '17px', '18px', '19px', '20px', '21px', '22px', '23px', '24px', '25px', '26px', '27px', '28px', '29px', '30px', '31px', '32px', '33px', '34px', '35px'
);
$border = array( '0px', '1px', '2px', '3px', '4px', '5px', '6px', '7px', '8px', '9px','10px' );
$imagelimit = array('2', '3', '4', '5', '6', '7', '8');
return array(
    array(
        'legend' => array(
            'title' => 'Main',
            'class' => 'an_theme-global',
            'id' => 'an_themeglobal'
        ),

        'fields' => array(
            'pageLoadProgressBar' => array(
                'title' => $module->l('Page load progress bar'),
                'options' => array(
                    'status' => array(
                        'title' => $module->l('Page load progress bar'),
                        'description' => $module->l(''),
                        'source' => 'switch',
						'type' => 'fileAdd',
						'files' => array(
										array(
											'position' => 'bottom',
											'path' => 'views/js/nprogress.js',
											'server' => 'local',
											'priority' => 200
										),
									),
                    ),
                    'color' => array(
                        'title' => $module->l('Color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#2fb5d2',
                    ),  
				),
			),
            
            // 'smoothscroll' => array(
            //     'title' => $module->l('Smooth Scroll'),
            //     'options' => array(
            //         'smoothscroll' => array(
            //             'title' => $module->l('Smooth Scroll'),
            //             'description' => $module->l(''),
            //             'source' => 'switch',
            //             'type' => 'fileAdd',
            //             'files' => array(
            //                             array(
            //                                 'position' => 'bottom',
            //                                 'path' => 'views/js/jquery.mCustomScrollbar.concat.min.js',
            //                                 'server' => 'local',
            //                                 'priority' => 200
            //                             ),
            //                             array(
            //                                 'type' => 'css',
            //                                 'priority' => 200,
            //                                 'path' => 'views/css/jquery.mCustomScrollbar.css',
            //                                 'server' => 'local',
            //                                 'media' => 'screen'
            //                             ),
            //                         ),
            //         ),
            //         'animationtime' => array(
            //             'title' => $module->l('Animation speed'),
            //             'description' => $module->l(''),
            //             'source' => 'select',
            //             'options' => $animationTime,
            //             'default' => '100',
            //         ),
            //         'stepsize' => array(
            //             'title' => $module->l('Animation step'),
            //             'description' => $module->l(''),
            //             'source' => 'select',
            //             'options' => $stepSize,
            //             'default' => '800',
            //         ),  
            //     ), 
            // ), 

            'global' => array(
                'title' => $module->l('Global'),
                'options' => array(
				/*
                    'animateWow' => array(
                        'title' => $module->l('animate.css'),
                        'description' => $module->l(''),
                        'source' => 'switch',
						'type' => 'fileAdd',
						'files' => array(
										array(
										    'type' => 'js',
											'position' => 'bottom',
											'path' => 'views/js/wow.min.js',
											'server' => 'local',
											'priority' => 200
										),
										array(
										    'type' => 'css',
											'priority' => 200,
											'path' => 'views/css/animate.min.css',
											'server' => 'local',
											'media' => 'screen'
										),
									),
                    ),
					*/
                    'themeFont' => array(
                        'title' => $module->l('Font from theme'),
						'description' => $module->l(''),
                        'source' => 'select',
                        'default' => 'opensans',
                        'type' => 'font',
                    ),
                    'basicColor' => array(
                        'title' => $module->l('Basic Color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#2fb5d2',
                    ),  
                    'bodyBackground' => array(
                        'title' => $module->l('body Background'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#ebebeb',
                    ),   
                    'link' => array(
                        'title' => $module->l('Link'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#2fb5d2',
                    ),					
                    'linkHover' => array(
                        'title' => $module->l('Link hover'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#208094',
                    ),   
                    'basicfontcolor' => array(
                        'title' => $module->l('Basic font color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#878787',
                    ),  
                    'basicfontsize' => array(
                        'title' => $module->l('Basic font size'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $fontSizes,
                        'default' => '16px',
                    ),
                    // 'BasicLineHeight' => array(
                    //     'title' => $module->l('Basic line height'),
                    //     'description' => $module->l(''),
                    //     'source' => 'select',
                    //     'options' => $lineHeight,
                    //     'default' => '16px',
                    // ),
                    'pfontsize' => array(
                        'title' => $module->l('tag p font size'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $fontSizes,
                        'default' => '16px',
                    ),
                    // 'pLineHeight' => array(
                    //     'title' => $module->l('tag p line height'),
                    //     'description' => $module->l(''),
                    //     'source' => 'select',
                    //     'options' => $fontSizes,
                    //     'default' => '16px',
                    // ),
                    'showquickview' => array(
                        'title' => $module->l('Quick view'),
                        'description' => $module->l(''),
                        'source' => 'switch',
                        'default' => '1',
                    ),
                    'quickviewbackground' => array(
                        'title' => $module->l('Quick view Background'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#ffffff',
                    ),
                ),
            ),
            
			///////////////////////////////
            'h1h6' => array(
                'title' => $module->l('H1-H6'),
                'options' => array(
                    'themeFontH' => array(
                        'title' => $module->l('Font H1-H4'),
						'description' => $module->l(''),
                        'source' => 'select',
                        'default' => 'opensans',
                        'type' => 'font',
                    ), 
                    'h1h5Color' => array(
                        'title' => $module->l('H1-H5 color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#414141',
                    ),
                    'h1FontSize' => array(
                        'title' => $module->l('H1 font-size'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $fontSizes,
                        'default' => '22px',
                    ),
                    'h2FontSize' => array(
                        'title' => $module->l('H2 font-size'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $fontSizes,
                        'default' => '20px',
                    ),
                    'h3h4FontSize' => array(
                        'title' => $module->l('H3-H4 font-size'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $fontSizes,
                        'default' => '18px',
                    ),
                    'h5FontSize' => array(
                        'title' => $module->l('H5 font-size'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $fontSizes,
                        'default' => '14px',
                    ),
                    'h6FontSize' => array(
                        'title' => $module->l('H6 font-size'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $fontSizes,
                        'default' => '15px',
                    ),
                ),
            ),


            /*


            */
            'wrapper' => array(
                'title' => $module->l('Breadcrumb'),
                 'options' => array(
                    'breadcrumbBackground' => array(
                        'title' => $module->l('Background color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#ebebeb',
                        'allow_empty' => true,
                    ),
                ), 
            ),
            
            'newslet' => array(
                'title' => $module->l('Newsletter'),
                'options' => array(
                    'background' => array(
                        'title' => $module->l('Background color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#ebebeb',
                        'allow_empty' => true,
                    ),
                )
            ), 

            'otherpage' => array(
                'title' => $module->l('CMS pages'),
                'options' => array(
                    'background' => array(
                        'title' => $module->l('Background color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#fff',
                        'allow_empty' => true,
                    ),
                    'paddinginternalpage' => array(
                        'title' => $module->l('Padding'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $padding,
                        'default' => '',
                    ),
                )
            ),
            
        ),
    ),
    array(
        'legend' => array(
            'title' => 'Header',
            'class' => 'an-theme-header',
            'id' => 'anthemeheader',
            'live' => true,
            'liveTitle' => 'Header test',
        ),
        
        

        'fields' => array(
            'header' => array(
                'title' => $module->l('Header Styles'),
                'options' => array(
                    'navBackground' => array(
                        'title' => $module->l('Background Nav'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#ebebeb',
						'allow_empty' => true,
                    ),
                    'fontSizeNav' => array(
                        'title' => $module->l('Font Size Nav'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $fontSizes,
                        'default' => '16px',
                    ),
                    'headerBackground' => array(
                        'title' => $module->l('Background Header'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#ffffff',
						'allow_empty' => true,
                    ), 
                    'headerlink' => array(
                        'title' => $module->l('Nav and Header Links Color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#2fb5d2',
                    ),                  
                    'headerlinkHover' => array(
                        'title' => $module->l( 'Nav and Header Links Hover Color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#208094',
                    ),     
/*                     'logoMiddle' => array(
                        'title' => $module->l('Logo in the middle'),
                        'description' => $module->l(''),
                        'source' => 'switch',
                    ), */
                )
            ),
            'topmenu' => array(
                'title' => $module->l('Top horizontal menu'),
                'options' => array(
                    'background' => array(
                        'title' => $module->l('Background'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#ffffff',
						'allow_empty' => true,
                    ),
                    'colorMenuLink' => array(
                        'title' => $module->l('Menu Color Link'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#353535',
						'allow_empty' => true,
                    ),
                    'colorMenuLinkHover' => array(
                        'title' => $module->l('Menu Hover Color Link'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#a4b501',
						'allow_empty' => true,
                    ),
                    'fontSize' => array(
                        'title' => $module->l('Font Size'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $fontSizes,
                        'default' => '16px',
                    ),
                    'stickyMenu' => array(
                        'title' => $module->l('Sticky Menu'),
                        'description' => $module->l(''),
                        'source' => 'switch',
						'type' => 'fileAdd',
						'files' => array(
										array(
											'position' => 'bottom',
											'path' => 'views/js/stickymenu.js',
											'server' => 'local',
											'priority' => 200
										),
									),
                    ),

                )
            ),  
        ),
    ),
  
    
    array(
        'legend' => array(
            'title' => 'Footer',
            'class' => 'an_theme-footer',
            'id' => 'anthemefooter'
        ),

        'fields' => array(
            'footer' => array(
                'title' => $module->l('Footer'),
                'options' => array(
                    'footerBackground' => array(
                        'title' => $module->l('Footer Background'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#ffffff',
						'allow_empty' => true,
                    ),
                    'footertitels' => array(
                        'title' => $module->l('Footer Titles Color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#2fb5d2',
                    ),
                    'footerlink' => array(
                        'title' => $module->l('Footer Link Color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#2fb5d2',
                    ),                  
                    'footerlinkHover' => array(
                        'title' => $module->l( 'Footer Link Hover Color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#208094',
                    ), 
                ),
            ),

            'copyright' => array(
                'title' => $module->l('Copyright'),
                'options' => array(
                    'copyrightBackground' => array(
                        'title' => $module->l('Copyright Background'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#ffffff',
						'allow_empty' => true,
                    ),
                    'showcopyright' => array(
                        'title' => $module->l('Show copyright'),
                        'description' => $module->l(''),
                        'source' => 'switch',
                        'default' => '1',
                    ),
                ),
            ),

        ),
    ),  


    array(
        'legend' => array(
            'title' => 'Product',
            'class' => 'an_theme-product',
            'id' => 'anthemeproduct'
        ),

        'fields' => array(

            'product' => array(
                'title' => $module->l('Product'),
                 'options' => array(
                    'productMobileRow' => array(
                        'title' => $module->l('Display 2 products in a row on mobile'),
                        'description' => $module->l(''),
                        'source' => 'switch',
                        'default' => '1',
                    ),
                    'productImageChange' => array(
                        'title' => $module->l('Catalog product image view type'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => array(
                            'standart' => 'default',
                            'hover' => 'hover',
                            'slider' => 'slider',
                            'hover-slider' => 'segmented view',
                        ),
                        'default' => '',
                        'type' => 'selectFileAdd',
                        'files' => array(
                            'hover' => array(
                                array(
                                    'type' => 'css',
                                    'priority' => 200,
                                    'path' => 'views/css/hoveronproducts.css',
                                    'server' => 'local',
                                    'media' => 'screen'
                                   ),
                            ),
                            'slider' => array(
                                array(
                                    'type' => 'js',
                                    'position' => 'bottom',
                                    'path' => 'views/js/slideronproducts.js',
                                    'server' => 'local',
                                    'priority' => 200
                                    ),
                                array(
                                    'type' => 'css',
                                    'priority' => 200,
                                    'path' => 'views/css/slideronproducts.css',
                                    'server' => 'local',
                                    'media' => 'screen'
                                   ),
                            ),
                        ),
                    ),
                    'backgroundMiniature' => array(
                        'title' => $module->l('Catalog product background'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#fff',
                    ),
                    'titleCatalogColor' => array(
                        'title' => $module->l('Product title in catalog color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#acaaa6',
                    ),
                    'titleCatalogFontSize' => array(
                        'title' => $module->l('Product title in catalog font-size'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $fontSizes,
                        'default' => '16px',
                    ),
                    'titleFontSize' => array(
                        'title' => $module->l('Product Title in product page font-size'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $fontSizes,
                        'default' => '20px',
                    ),
                    //////
                    'priceColor' => array(
                        'title' => $module->l('Price color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#414141',
                    ),
                    'priceFontSize' => array(
                        'title' => $module->l('Price in catalog font-size'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $fontSizes,
                        'default' => '20px',
                    ),
                    'oldPriceColor' => array(
                        'title' => $module->l('Non-discount price color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#acaaa6',
                    ),
                    'oldPriceFontSize' => array(
                        'title' => $module->l('Non-discount in catalog font-size'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $fontSizes,
                        'default' => '20px',
                    ),
                     'borderImageCatalog' => array(
                        'title' => $module->l('Size of image border in catalog'),
                        'description' => $module->l(''),
                        'source' => 'number',
                        'min' => 0,
                        'max' => 30,
                        'default' => '0',
                        'allow_empty' => true
                    ),              
                    'borderImageColorCatalog' => array(
                        'title' => $module->l('Color of image border in catalog'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'allow_empty' => true
                    ),
                    'backgroundOnlineOnly' => array(
                        'title' => $module->l('Background Label Online Only'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'allow_empty' => true,
                        'default' => '#2fb5d2'
                    ),
                    'colorOnlineOnly' => array(
                        'title' => $module->l('Color Online Only'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'allow_empty' => true,
                        'default' => '#ffffff'
                    ),
                    'backgroundOnSale' => array(
                        'title' => $module->l('Background Label On Sale'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'allow_empty' => true,
                        'default' => '#2fb5d2'
                    ),
                    'colorOnSale' => array(
                        'title' => $module->l('Color On Sale'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'allow_empty' => true,
                        'default' => '#ffffff'
                    ),
                    'backgroundNew' => array(
                        'title' => $module->l('Background Label New'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'allow_empty' => true,
                        'default' => '#2fb5d2'
                    ),
                    'colorNew' => array(
                        'title' => $module->l('Color New'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'allow_empty' => true,
                        'default' => '#ffffff'
                    ),
                    'backgroundSale' => array(
                        'title' => $module->l('Background Label Discount Percentage'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'allow_empty' => true,
                        'default' => '#2fb5d2'
                    ),
                    'colorSale' => array(
                        'title' => $module->l('Color Discount Percentage'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'allow_empty' => true,
                        'default' => '#ffffff'
                    ),
                    'backgroundTabs' => array(
                        'title' => $module->l('Product page tabs background'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'allow_empty' => true,
                        'default' => '#ffffff'
                    ),
                    'slideronproductpage' => array(
                        'title' => $module->l('Related products slider'),
                        'description' => $module->l(''),
                        'source' => 'switch',
                        'type' => 'fileAdd',
                        'files' => array(
                                        array(
                                            'position' => 'bottom',
                                            'path' => 'views/js/init_slider_on_product_page.js',
                                            'server' => 'local',
                                            'priority' => 200
                                        ),
                                    ),
                    ),
                     
                     'shortdescription' => array(
                        'title' => $module->l('Thumbnail product short description'),
                        'description' => $module->l(''),
                        'source' => 'switch',
                        'default' => '1',
                    ),
                    'shortdescriptionlength' => array(
                       'title' => $module->l('Thumbnail product short description max length'),
                       'description' => $module->l(''),
                       'source' => 'number',
                       'min' => 10,
                       'max' => 350, 
                       'default' => '65',
                       'allow_empty' => false 
                    ),
                     'imageQuickLookBar' => array(
                        'title' => $module->l('Image quick look bar'),
                        'description' => $module->l(''),
                        'source' => 'switch',
                        'default' => '0',
                    ),
                ), 
            ),
            'segmentedviewsettinds' => array(
                'title' => $module->l('Segmented view settings'),
                'options' => array(
                    'imagelimit' => array(
                        'title' => $module->l('Image limit'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $imagelimit,
                        'default' => '5',
                    ),
                    'linecolor' => array(
                        'title' => $module->l('Lines color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'allow_empty' => true,
                        'default' => '#e8e8e8'
                    ),
                    'activelinecolor' => array(
                        'title' => $module->l('Active line color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'allow_empty' => true,
                        'default' => '#00aaff'
                    ),
                    'textcolorsh' => array(
                        'title' => $module->l('Text color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'allow_empty' => true,
                        'default' => '#000000'
                    ),
                    'textonlastimg' => array(
                        'title' => $module->l('More images'),
                        'description' => $module->l(''),
                        'source' => 'switch',
                        'default' => '1',
                    ),
                ),
            ),
        ),
    ), 
    

    array(
        'legend' => array(
            'title' => 'Category Page',
            'class' => 'an_theme-categorypage',
            'id' => 'anthemecategorypage'
        ),

        'fields' => array(

            'categoryPage' => array(
                'title' => $module->l('Left Column'),
                'options' => array(
                    'productsAmount' => array(
                        'title' => $module->l('Quantity of products in a row'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => array(
                            'col-xs-12' => '1 product',
                            'col-xs-6' => '2 products',
                            'col-xs-4' => '3 products',
                            'col-xs-3' => '4 products',
                        ),
                        'default' => 'col-xs-4',
                    ),
                    'backgroundleftcolumn' => array(
                        'title' => $module->l('Background color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'allow_empty' => true,
                        'default' => '',
                    ),
                    'leftcolumnpadding' => array(
                        'title' => $module->l('Padding'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $padding,
                        'default' => '0px',
                    ),
                    'facetedsearch' => array(
                        'title' => $module->l('Faceted search type of view'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => array(
                            'standard' => 'Expanded and unavailable to collapse (default)',
                            'turnon' => 'Expanded and available to collapse',
                            'turnoff' => 'Collapsed and available to expand',
                        ),
                        'default' => 'standard',
                    ),

                ),
            ),

            'categorydescription' => array(
                'title' => $module->l('Category Description Box'),
                'options' => array(
                    'showCategoryDescription' => array(
                        'title' => $module->l('Show Category Description'),
                        'description' => $module->l(''),
                        'source' => 'switch',
                        ),
                    
                    'backgrounddescription' => array(
                            'title' => $module->l('Background color'),
                            'description' => $module->l(''),
                            'source' => 'picker',
                            'allow_empty' => true,
                            'default' => '',
                        ),

                    'paddingdescription' => array(
                        'title' => $module->l('Padding'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $padding,
                        'default' => '0px',
                        ),
                ),
            ),

        ),
    ), 
    array(
    'legend' => array(
        'title' => 'Shopping cart',
        'class' => 'an_theme-shoping-cart',
        'id' => 'anthemeshoppingcart'
    ),

    'fields' => array(
	       'shoppingCart' => array(
                'title' => $module->l('Shopping Cart'),
                'options' => array(
                  'sidebarCart' => array(
                    'title' => $module->l('Sidebar Mini Cart'),
                    'description' => $module->l(''),
                    'source' => 'switch',
                    'type' => 'fileAdd',
                    'files' => array(
                        array(
                            'type' => 'js',
                            'position' => 'bottom',
                            'path' => 'views/js/sidebarcart.js',
                            'server' => 'local',
                            'priority' => 200
                            ),
                        array(
                            'type' => 'css',
                            'priority' => 200,
                            'path' => 'views/css/sidebarcart.css',
                            'server' => 'local',
                            'media' => 'screen'
                            ),
                        ),
                    ),
                    'fontsizegsc' => array(
                        'title' => $module->l('Sidebar title font size'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $fontSizes,
                        'default' => '24px',
                    ),
                    'backgroundsc' => array(
                        'title' => $module->l('Title and prices block background color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#f4f4f4',
                        'allow_empty' => true,
                    ),
                    'backgroun2dsc' => array(
                        'title' => $module->l('Product block background color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#fff',
                        'allow_empty' => true,
                    ),
                    'paddingsc' => array(
                        'title' => $module->l('Padding'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $padding,
                        'default' => '0px',
                    ),
                    'backgroundsc2' => array(
                        'title' => $module->l('Cart total block Background color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#fff',
                        'allow_empty' => true,
                    ),
                    'paddingsc2' => array(
                        'title' => $module->l('Cart total block Padding'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $padding,
                        'default' => '0px',
                    ),
                  ),
                ),
           'orderpage' => array(
                'title' => $module->l('Order Pages'),
                'options' => array(
                     'backgroundorder' => array(
                        'title' => $module->l('Background color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#fff',
                        'allow_empty' => true,
                    ),
                    'paddingorder' => array(
                        'title' => $module->l('Padding'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $padding,
                        'default' => '0px',
                    ),
                  ),
                ),
        ),
    ), 
    
    array(
        'legend' => array(
            'title' => 'Home Slider',
            'class' => 'an_theme-anthemeblocks-homeslider',
            'id' => 'anthemecategorypage'
        ),

        'fields' => array(
            'homeSlider' => array(
                'title' => $module->l('Home Slider (if enabled)'),
                'options' => array(
                    'sliderFont' => array(
                        'title' => $module->l('Slider font'),
						'description' => $module->l(''),
                        'source' => 'select',
                        'default' => 'opensans',
                        'type' => 'font',
                    ),
                    'titleColor' => array(
                        'title' => $module->l('Title Color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#ffffff',
						'allow_empty' => true,
                    ),
                    'TitleFontSize' => array(
                        'title' => $module->l('Title Font Size'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $fontSizeSlider,
                        'default' => '16px',
                    ),
                    'descriptionColor' => array(
                        'title' => $module->l('Description Color'),
                        'description' => $module->l(''),
                        'source' => 'picker',
                        'default' => '#ffffff',
						'allow_empty' => true,
                    ),
                    'descriptionFontSize' => array(
                        'title' => $module->l('Description Font Size'),
                        'description' => $module->l(''),
                        'source' => 'select',
                        'options' => $fontSizeSlider,
                        'default' => '16px',
                    ),
                ),
            ),
        ),
    ), 
	
    array(
            'legend' => array(
                'title' => 'Buttons',
                'class' => 'an_theme-buttons',
                'id' => 'anthemebuttons'
            ),

            'fields' => array(
                'buttons' => array(
                    'title' => $module->l('Buttons'),
                    'options' => array(
                        'backgroundButton' => array(
                            'title' => $module->l('Background Button'),
                            'description' => $module->l(''),
                            'source' => 'picker',
                            'default' => '#2fb5d2',
                        ),
                        'backgroundHoverButton' => array(
                            'title' => $module->l('Background Hover Button'),
                            'description' => $module->l(''),
                            'source' => 'picker',
                            'default' => '#ffff00',
                        ),
                        'borderwidthButton' => array(
                            'title' => $module->l('Size of button border'),
                            'description' => $module->l(''),
                            'source' => 'select',
                            'options' => $border,
                            'default' => '0px',
                        ),
                        'bordercolorButton' => array(
                            'title' => $module->l('Color of button border'),
                            'description' => $module->l(''),
                            'source' => 'picker',
                            'default' => '#2fb5d2',
                        ),
                        'colorHoverBorder' => array(
                            'title' => $module->l('Color of hover button border'),
                            'description' => $module->l(''),
                            'source' => 'picker',
                            'default' => '#ffff00',
                        ),
                        'ButtonBorderRadius' => array(
                            'title' => $module->l('Button border-radius'),
                            'description' => $module->l(''),
                            'source' => 'select',
                            'options' => $border_radius,
                            'default' => '0px',
                        ),
                        'colorButton' => array(
                            'title' => $module->l('Color Font Button'),
                            'description' => $module->l(''),
                            'source' => 'picker',
                            'default' => '#000000',
                        ),
                        'colorButtonHover' => array(
                            'title' => $module->l('Color Font Hover Button'),
                            'description' => $module->l(''),
                            'source' => 'picker',
                            'default' => '#000000',
                        ),
                        'buttoneffect' => array(
                            'title' => $module->l('Button animation effect'),
                            'description' => $module->l(''),
                            'source' => 'switch',
                            'type' => 'fileAdd',
                            'files' => array(
                                array(
                                    'type' => 'css',
                                    'priority' => 200,
                                    'path' => 'views/css/buttons_effect.css',
                                    'server' => 'local',
                                    'media' => 'screen'
                                ),
                            ),
                        ),

                    ),
                ),
                'btnAddToCart' => array (
                    'title' => $module->l('Add to cart button on miniature'),
                    'options' => array(
                        
                        'backgroundAddtocart' => array(
                            'title' => $module->l('Background Button'),
                            'description' => $module->l(''),
                            'source' => 'picker',
                            'default' => '#2fb5d2',
                        ),
                        'backgroundHoverAddtocart' => array(
                            'title' => $module->l('Background Hover Button'),
                            'description' => $module->l(''),
                            'source' => 'picker',
                            'default' => '#ffff00',
                        ),
                        'borderWidthAddtocart' => array(
                            'title' => $module->l('Size of button border'),
                            'description' => $module->l(''),
                            'source' => 'select',
                            'options' => $border,
                            'default' => '0px',
                        ),
                        'borderColorAddtocart' => array(
                            'title' => $module->l('Color of button border'),
                            'description' => $module->l(''),
                            'source' => 'picker',
                            'default' => '#2fb5d2',
                        ),
                        'borderColorHoverAddtocart' => array(
                            'title' => $module->l('Color of hover button border'),
                            'description' => $module->l(''),
                            'source' => 'picker',
                            'default' => '#ffff00',
                        ),
                        'borderRadiusAddtocart' => array(
                            'title' => $module->l('Button border-radius'),
                            'description' => $module->l(''),
                            'source' => 'select',
                            'options' => $border_radius,
                            'default' => '0px',
                        ),
                        'colorAddtocart' => array(
                            'title' => $module->l('Color Font Button'),
                            'description' => $module->l(''),
                            'source' => 'picker',
                            'default' => '#000000',
                        ),
                        'colorHoverAddtocart' => array(
                            'title' => $module->l('Color Font Hover Button'),
                            'description' => $module->l(''),
                            'source' => 'picker',
                            'default' => '#000000',
                        ),
                    ),
                ),
            ),
        ),
    array(
        'legend' => array(
            'title' => 'JS/CSS',
            'class' => 'an_theme-code',
            'id' => 'anthemecode'
        ),

        'fields' => array(
            'custom_code' => array(
                'title' => $module->l('Custom code'),
                'options' => array(
                    'code_css' => array(
                        'title' => $module->l('Header code CSS'),
                        'description' => $module->l(''),
                        'type' => 'textarea',
                        'file_type' => 'css',
                        'source' => 'textarea',
                        'rows' => '16',
                        'default' => '',
                    ),
                    'code_js' => array(
                        'title' => $module->l('Header code JS'),
                        'description' => $module->l(''),
                        'type' => 'textarea',
                        'file_type' => 'js',
                        'source' => 'textarea',
                        'rows' => '16',
                        'default' => '',
                    ),
                ),
            ),
        ),
    ),
);



$animateCss = array(
    array(
        'label' => 'none',
        'query' => array(
            'none' => 'none',
        ),
    ),
    array(
        'label' => 'Attention Seekers',
        'query' => array(
			'wow bounce' => 'bounce',
			'wow flash' => 'flash',
			'wow pulse' => 'pulse',
			'wow rubberBand' => 'rubberBand',
			'wow shake' => 'shake',
			'wow headShake' => 'headShake',
			'wow swing' => 'swing',
			'wow tada' => 'tada',
			'wow wobble' => 'wobble',
			'wow jello' => 'jello',
        ),
    ),
    array(
        'label' => 'Bouncing Entrances',
        'query' => array(
			'wow bounceIn' => 'bounceIn',
			'wow bounceInDown' => 'bounceInDown',
			'wow bounceInLeft' => 'bounceInLeft',
			'wow bounceInRight' => 'bounceInRight',
			'wow bounceInUp' => 'bounceInUp',
        ),
    ),
    array(
        'label' => 'Bouncing Exits',
        'query' => array(
			'wow bounceOut' => 'bounceOut',
			'wow bounceOutDown' => 'bounceOutDown',
			'wow bounceOutLeft' => 'bounceOutLeft',
			'wow bounceOutRight' => 'bounceOutRight',
			'wow bounceOutUp' => 'bounceOutUp',
        ),
    ),
    array(
        'label' => 'Fading Entrances',
        'query' => array(
			'wow fadeIn' => 'fadeIn',
			'wow fadeInDown' => 'fadeInDown',
			'wow fadeInDownBig' => 'fadeInDownBig',
			'wow fadeInLeft' => 'fadeInLeft',
			'wow fadeInLeftBig' => 'fadeInLeftBig',
			'wow fadeInRight' => 'fadeInRight',
			'wow fadeInRightBig' => 'fadeInRightBig',
			'wow fadeInUp' => 'fadeInUp',
			'wow fadeInUpBig' => 'fadeInUpBig',
        ),
    ),
    array(
        'label' => 'Fading Exits',
        'query' => array(
			'wow fadeOut' => 'fadeOut',
			'wow fadeOutDown' => 'fadeOutDown',
			'wow fadeOutDownBig' => 'fadeOutDownBig',
			'wow fadeOutLeft' => 'fadeOutLeft',
			'wow fadeOutLeftBig' => 'fadeOutLeftBig',
			'wow fadeOutRight' => 'fadeOutRight',
			'wow fadeOutRightBig' => 'fadeOutRightBig',
			'wow fadeOutUp' => 'fadeOutUp',
			'wow fadeOutUpBig' => 'fadeOutUpBig',
        ),
    ),
    array(
        'label' => 'Flippers',
        'query' => array(
			'wow flipInX' => 'flipInX',
			'wow flipInY' => 'flipInY',
			'wow flipOutX' => 'flipOutX',
			'wow flipOutY' => 'flipOutY',
        ),
    ),
    array(
        'label' => 'Lightspeed',
        'query' => array(
			'wow lightSpeedIn' => 'lightSpeedIn',
			'wow lightSpeedOut' => 'lightSpeedOut',
        ),
    ),
    array(
        'label' => 'Rotating Entrances',
        'query' => array(
			'wow rotateIn' => 'rotateIn',
			'wow rotateInDownLeft' => 'rotateInDownLeft',
			'wow rotateInDownRight' => 'rotateInDownRight',
			'wow rotateInUpLeft' => 'rotateInUpLeft',
			'wow rotateInUpRight' => 'rotateInUpRight',
        ),
    ),
    array(
        'label' => 'Rotating Exits',
        'query' => array(
			'wow rotateOut' => 'rotateOut',
			'wow rotateOutDownLeft' => 'rotateOutDownLeft',
			'wow rotateOutDownRight' => 'rotateOutDownRight',
			'wow rotateOutUpLeft' => 'rotateOutUpLeft',
			'wow rotateOutUpRight' => 'rotateOutUpRight',
        ),
    ),
    array(
        'label' => 'Specials',
        'query' => array(
			'wow hinge' => 'hinge',
			'wow rollIn' => 'rollIn',
			'wow rollOut' => 'rollOut',
        ),
    ),
    array(
        'label' => 'Sliding Entrances',
        'query' => array(
			'wow slideInDown' => 'slideInDown',
			'wow slideInLeft' => 'slideInLeft',
			'wow slideInRight' => 'slideInRight',
        ),
    ),
    array(
        'label' => 'Sliding Entrances',
        'query' => array(
			'wow slideInUp' => 'slideInUp',
			'wow slideOutDown' => 'slideOutDown',
			'wow slideOutLeft' => 'slideOutLeft',
			'wow slideOutRight' => 'slideOutRight',
			'wow slideOutUp' => 'slideOutUp',
        ),
    ),
    array(
        'label' => 'Zoom Entrances',
        'query' => array(
			'wow zoomIn' => 'zoomIn',
			'wow zoomInDown' => 'zoomInDown',
			'wow zoomInLeft' => 'zoomInLeft',
			'wow zoomInRight' => 'zoomInRight',
			'wow zoomInUp' => 'zoomInUp',
        ),
    ),
    array(
        'label' => 'Zoom Exits',
        'query' => array(
			'wow zoomOut' => 'zoomOut',
			'wow zoomOutDown' => 'zoomOutDown',
			'wow zoomOutLeft' => 'zoomOutLeft',
			'wow zoomOutRight' => 'zoomOutRight',
			'wow zoomOutUp' => 'zoomOutUp',
        ),
    ),
);
<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"] . "/bitrix/templates/" . SITE_TEMPLATE_ID . "/header.php");
CJSCore::Init(array("fx"));
$curPage = $APPLICATION->GetCurPage(true);
$theme = COption::GetOptionString("main", "wizard_eshop_bootstrap_theme_id", "blue", SITE_ID);
?>
    <!DOCTYPE html>
<html xml:lang="<?= LANGUAGE_ID ?>" lang="<?= LANGUAGE_ID ?>">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
        <link rel="shortcut icon" type="image/x-icon" href="<?= SITE_DIR ?>favicon.ico"/>
        <? $APPLICATION->ShowHead(); ?>
        <?
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/colors.css", true);
        $APPLICATION->SetAdditionalCSS("/bitrix/css/main/bootstrap.css");
        $APPLICATION->SetAdditionalCSS("/bitrix/css/main/font-awesome.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/styles.css", true);
        ?>
        <title><? $APPLICATION->ShowTitle() ?></title>
    </head>
<body>
    <div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
<? // $APPLICATION->IncludeComponent("bitrix:eshop.banner", "", array()); ?>
<div class="bx-wrapper" id="bx_eshop_wrap">

    <header class="<? if (CSite::InDir('/index.php')) { ?>home bg<? } ?><? if (CSite::InDir('/catalog/')) { ?> catalog<? } ?>">


        <div class="mainMenu<? if (CSite::InDir('/catalog/')) { ?> color-black<? } ?>">
            <div class="language">RU
                <span class="icon_small icon_small_arrow"></span>
            </div>
            <div class="soc">
                <a href="https://vk.com/public112773298" target="_blank" class="vk"></a><a href="#" class="insta"></a><a href="#" class="fb"></a><a href="#"
                                                                                                       class="ok"></a><a
                        href="#" class="tw"></a>
            </div>
            <div class="testDrive">
                    <span class="icon_small icon_small_write"></span><span class="dashadLine">Записаться на тест-драйв</span>
                
            </div>
            <div class="phone">                
                <span class="icon_small icon_small_phone"></span>                
                <span class="deltext">Горячая линия «Мастер лодок» </span> +7 (347) 226-56-00
            </div>
            <div class="lk">
                <span class="icon_small icon_small_lk"></span>
                <a href="#" class="underline">
                    <span class="deltext">Личный </span>кабинет</a> /
                <a href="#" class="underline">Регистрация</a>
                <!-- <a href="#"><span class="icon_small icon_small_basket"></span></a> -->
            </div>
            <div class="search"><span class="icon_big icon_big_search"></span></div>
        </div>

<div class="fixed_container fixed_container_navbar">
        <div class="container<? if (CSite::InDir('/index.php')){ ?>-fluid<? } ?>">
            <div class="row">

                <nav class="navbar navbar-default mainNav" role="navigation">

                    <div class="container-fluid">

                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                    data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="/">
                                <img class="logo"
                                     src="<?= SITE_TEMPLATE_PATH ?>/images/logo_.png"
                                     alt=""></a>
                        </div>

                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                            <? $APPLICATION->IncludeComponent(
                                "bitrix:menu",
                                ".default",
                                array(
                                    "ROOT_MENU_TYPE" => "left",
                                    "MENU_CACHE_TYPE" => "N",
                                    "MENU_CACHE_TIME" => "36000000",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "MENU_THEME" => "site",
                                    "CACHE_SELECTED_ITEMS" => "N",
                                    "MENU_CACHE_GET_VARS" => array(),
                                    "MAX_LEVEL" => "1",
                                    "CHILD_MENU_TYPE" => "left",
                                    "USE_EXT" => "N",
                                    "DELAY" => "N",
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "COMPONENT_TEMPLATE" => ".default"
                                ),
                                false
                            ); ?>

                        </div><!-- /.navbar-collapse -->

                    </div><!-- /.container-fluid -->

                </nav>



            </div>
        </div>
 </div>

        <? if (CSite::InDir('/index.php')) { ?>
            <div class="mainTitle"><? $APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/home_title.php"), false); ?></div>
        <? }
            if (CSite::InDir('/catalog/')) {
            $APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/catalog_title.php"), false); ?>
            <div class="container-flud imgGrayLine">
            <? $APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/section_logo.php"), false); ?>
            </div>
<div class="fixed_container fixed_categoryMenu">
                <div class="container-fluid gray">
                    <!-- Меню категорий -->
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "menu_catalog",
                        array(
                            "ROOT_MENU_TYPE" => "catalog",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_TIME" => "36000000",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_THEME" => "site",
                            "CACHE_SELECTED_ITEMS" => "N",
                            "MENU_CACHE_GET_VARS" => array(
                            ),
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "catalog",
                            "USE_EXT" => "N",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                            "COMPONENT_TEMPLATE" => ".default"
                        ),
                        false
                    ); ?>
                </div>
            <? } ?>
</div>
<div class="fixedFixBlock"></div>
    </header>


<? /*
    <header class="bx-header">
        <div class="bx-header-section container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="bx-logo">
                        <a class="bx-logo-block hidden-xs" href="<?= SITE_DIR ?>">
                            <? $APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/company_logo.php"), false); ?>
                        </a>
                        <a class="bx-logo-block hidden-lg hidden-md hidden-sm text-center" href="<?= SITE_DIR ?>">
                            <? $APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/company_logo_mobile.php"), false); ?>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="bx-inc-orginfo">
                        <div>
                            <span class="bx-inc-orginfo-phone"><i
                                        class="fa fa-phone"></i> <? $APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/telephone.php"), false); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
                    <div class="bx-worktime">
                        <div class="bx-worktime-prop">
                            <? $APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/schedule.php"), false); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 hidden-xs">
                    <? $APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "", array(
                        "PATH_TO_BASKET" => SITE_DIR . "personal/cart/",
                        "PATH_TO_PERSONAL" => SITE_DIR . "personal/",
                        "SHOW_PERSONAL_LINK" => "N",
                        "SHOW_NUM_PRODUCTS" => "Y",
                        "SHOW_TOTAL_PRICE" => "Y",
                        "SHOW_PRODUCTS" => "N",
                        "POSITION_FIXED" => "N",
                        "SHOW_AUTHOR" => "Y",
                        "PATH_TO_REGISTER" => SITE_DIR . "login/",
                        "PATH_TO_PROFILE" => SITE_DIR . "personal/"
                    ),
                        false,
                        array()
                    ); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 hidden-xs">
                    <? $APPLICATION->IncludeComponent("bitrix:menu", "catalog_horizontal", array(
                        "ROOT_MENU_TYPE" => "left",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "36000000",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_THEME" => "site",
                        "CACHE_SELECTED_ITEMS" => "N",
                        "MENU_CACHE_GET_VARS" => array(),
                        "MAX_LEVEL" => "3",
                        "CHILD_MENU_TYPE" => "left",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                    ),
                        false
                    ); ?>
                </div>
            </div>
            <? if ($curPage != SITE_DIR . "index.php"): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <? $APPLICATION->IncludeComponent("bitrix:search.title", "visual", array(
                            "NUM_CATEGORIES" => "1",
                            "TOP_COUNT" => "5",
                            "CHECK_DATES" => "N",
                            "SHOW_OTHERS" => "N",
                            "PAGE" => SITE_DIR . "catalog/",
                            "CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS"),
                            "CATEGORY_0" => array(
                                0 => "iblock_catalog",
                            ),
                            "CATEGORY_0_iblock_catalog" => array(
                                0 => "all",
                            ),
                            "CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
                            "SHOW_INPUT" => "Y",
                            "INPUT_ID" => "title-search-input",
                            "CONTAINER_ID" => "search",
                            "PRICE_CODE" => array(
                                0 => "BASE",
                            ),
                            "SHOW_PREVIEW" => "Y",
                            "PREVIEW_WIDTH" => "75",
                            "PREVIEW_HEIGHT" => "75",
                            "CONVERT_CURRENCY" => "Y"
                        ),
                            false
                        ); ?>
                    </div>
                </div>
            <? endif ?>

            <? if ($curPage != SITE_DIR . "index.php"): ?>
                <div class="row">
                    <div class="col-lg-12" id="navigation">
                        <? $APPLICATION->IncludeComponent("bitrix:breadcrumb", "", array(
                            "START_FROM" => "0",
                            "PATH" => "",
                            "SITE_ID" => "-"
                        ),
                            false,
                            Array('HIDE_ICONS' => 'Y')
                        ); ?>
                    </div>
                </div>
                <h1 class="bx-title dbg_title" id="pagetitle"><?= $APPLICATION->ShowTitle(false); ?></h1>
            <? endif ?>
        </div>
    </header>
*/ ?>


    <main>
        <div class="container">

<? /*
    <div class="workarea">
        <div class="container bx-content-seection">
            <div class="row">
                <? $needSidebar = preg_match("~^" . SITE_DIR . "(catalog|personal\/cart|personal\/order\/make)/~", $curPage); ?>
                <div class="bx-content <?= ($needSidebar ? "col-xs-12" : "col-md-9 col-sm-8") ?>">
                    */ ?>
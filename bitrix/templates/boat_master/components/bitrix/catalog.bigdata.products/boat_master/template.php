<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */
/** @global CMain $APPLICATION */

$frame = $this->createFrame()->begin("");

$templateData = array(
    'TEMPLATE_THEME' => $this->GetFolder() . '/themes/' . $arParams['TEMPLATE_THEME'] . '/style.css',
    'TEMPLATE_CLASS' => 'bx_' . $arParams['TEMPLATE_THEME']
);

$injectId = $arParams['UNIQ_COMPONENT_ID'];

if (isset($arResult['REQUEST_ITEMS'])) {
    // code to receive recommendations from the cloud
    CJSCore::Init(array('ajax'));

    // component parameters
    $signer = new \Bitrix\Main\Security\Sign\Signer;
    $signedParameters = $signer->sign(
        base64_encode(serialize($arResult['_ORIGINAL_PARAMS'])),
        'bx.bd.products.recommendation'
    );
    $signedTemplate = $signer->sign($arResult['RCM_TEMPLATE'], 'bx.bd.products.recommendation');

    ?>

    <span id="<?= $injectId ?>"></span>

    <script type="text/javascript">
        BX.ready(function () {
            bx_rcm_get_from_cloud(
                '<?=CUtil::JSEscape($injectId)?>',
                <?=CUtil::PhpToJSObject($arResult['RCM_PARAMS'])?>,
                {
                    'parameters': '<?=CUtil::JSEscape($signedParameters)?>',
                    'template': '<?=CUtil::JSEscape($signedTemplate)?>',
                    'site_id': '<?=CUtil::JSEscape(SITE_ID)?>',
                    'rcm': 'yes'
                }
            );
        });
    </script>
    <?
    $frame->end();
    return;

    // \ end of the code to receive recommendations from the cloud
}


// regular template then
// if customized template, for better js performance don't forget to frame content with <span id="{$injectId}_items">...</span> 

if (!empty($arResult['ITEMS'])) {
    ?>

    <span id="<?= $injectId ?>_items">
	
	<script type="text/javascript">
	BX.message({
        CBD_MESS_BTN_BUY: '<? echo('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CVP_TPL_MESS_BTN_BUY')); ?>',
        CBD_MESS_BTN_ADD_TO_BASKET: '<? echo('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CVP_TPL_MESS_BTN_ADD_TO_BASKET')); ?>',
        CBD_MESS_BTN_DETAIL: '<? echo('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CVP_TPL_MESS_BTN_DETAIL')); ?>',
        CBD_MESS_NOT_AVAILABLE: '<? echo('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CVP_TPL_MESS_BTN_DETAIL')); ?>',
        CBD_BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
        CBD_BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
        CBD_ADD_TO_BASKET_OK: '<? echo GetMessageJS('CVP_ADD_TO_BASKET_OK'); ?>',
        CBD_TITLE_ERROR: '<? echo GetMessageJS('CVP_CATALOG_TITLE_ERROR') ?>',
        CBD_TITLE_BASKET_PROPS: '<? echo GetMessageJS('CVP_CATALOG_TITLE_BASKET_PROPS') ?>',
        CBD_TITLE_SUCCESSFUL: '<? echo GetMessageJS('CVP_ADD_TO_BASKET_OK'); ?>',
        CBD_BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CVP_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
        CBD_BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
        CBD_BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_CLOSE') ?>'
    });
	</script>
        <?

        $arSkuTemplate = array();
        if (is_array($arResult['SKU_PROPS'])) {
            foreach ($arResult['SKU_PROPS'] as $iblockId => $skuProps) {
                $arSkuTemplate[$iblockId] = array();
                foreach ($skuProps as &$arProp) {
                    ob_start();
                    if ('TEXT' == $arProp['SHOW_MODE']) {
                        if (5 < $arProp['VALUES_COUNT']) {
                            $strClass = 'bx_item_detail_size full';
                            $strWidth = ($arProp['VALUES_COUNT'] * 20) . '%';
                            $strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
                            $strSlideStyle = '';
                        } else {
                            $strClass = 'bx_item_detail_size';
                            $strWidth = '100%';
                            $strOneWidth = '20%';
                            $strSlideStyle = 'display: none;';
                        }
                        ?>
                    <div class="<? echo $strClass; ?>" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_cont">
                        <span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>

					<div class="bx_size_scroller_container">
						<div class="bx_size">
							<ul id="#ITEM#_prop_<? echo $arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;"><?
                                foreach ($arProp['VALUES'] as $arOneValue) {
                                    ?>
                                <li
                                        data-treevalue="<? echo $arProp['ID'] . '_' . $arOneValue['ID']; ?>"
                                        data-onevalue="<? echo $arOneValue['ID']; ?>"
                                        style="width: <? echo $strOneWidth; ?>;"
                                ><i></i><span class="cnt"><? echo htmlspecialcharsex($arOneValue['NAME']); ?></span>
                                    </li><?
                                }
                                ?></ul>
						</div>
						<div class="bx_slide_left" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_left"
                             data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
						<div class="bx_slide_right" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_right"
                             data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
					</div>
                        </div><?
                    } elseif ('PICT' == $arProp['SHOW_MODE']) {
                        if (5 < $arProp['VALUES_COUNT']) {
                            $strClass = 'bx_item_detail_scu full';
                            $strWidth = ($arProp['VALUES_COUNT'] * 20) . '%';
                            $strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
                            $strSlideStyle = '';
                        } else {
                            $strClass = 'bx_item_detail_scu';
                            $strWidth = '100%';
                            $strOneWidth = '20%';
                            $strSlideStyle = 'display: none;';
                        }
                        ?>
                    <div class="<? echo $strClass; ?>" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_cont">
                        <span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>

					<div class="bx_scu_scroller_container">
						<div class="bx_scu">
							<ul id="#ITEM#_prop_<? echo $arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;"><?
                                foreach ($arProp['VALUES'] as $arOneValue) {
                                    ?>
                                <li
                                        data-treevalue="<? echo $arProp['ID'] . '_' . $arOneValue['ID'] ?>"
                                        data-onevalue="<? echo $arOneValue['ID']; ?>"
                                        style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"
                                ><i title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"></i>
							<span class="cnt"><span class="cnt_item"
                                                    style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');"
                                                    title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"
                                ></span></span></li><?
                                }
                                ?></ul>
						</div>
						<div class="bx_slide_left" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_left"
                             data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
						<div class="bx_slide_right" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_right"
                             data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
					</div>
                        </div><?
                    }
                    $arSkuTemplate[$iblockId][$arProp['CODE']] = ob_get_contents();
                    ob_end_clean();
                    unset($arProp);
                }
            }
        }

        ?>
        <div class="bx_item_list_you_looked_horizontal col<? echo $arParams['LINE_ELEMENT_COUNT']; ?> <? echo $templateData['TEMPLATE_CLASS']; ?> bigdata_recommended">
	<div class="bx_item_list_title"><? echo GetMessage('CVP_TPL_MESS_RCM') ?></div>


	<div class="bx_item_list_section">


	<div class="bx_item_list_slide active">



	<?
    foreach ($arResult['ITEMS'] as $key => $arItem) {
        $strMainID = $this->GetEditAreaId($arItem['ID'] . $key);

        $arItemIDs = array(
            'ID' => $strMainID,
            'PICT' => $strMainID . '_pict',
            'SECOND_PICT' => $strMainID . '_secondpict',
            'MAIN_PROPS' => $strMainID . '_main_props',

            'QUANTITY' => $strMainID . '_quantity',
            'QUANTITY_DOWN' => $strMainID . '_quant_down',
            'QUANTITY_UP' => $strMainID . '_quant_up',
            'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
            'BUY_LINK' => $strMainID . '_buy_link',
            'BASKET_ACTIONS' => $strMainID . '_basket_actions',
            'NOT_AVAILABLE_MESS' => $strMainID . '_not_avail',
            'SUBSCRIBE_LINK' => $strMainID . '_subscribe',

            'PRICE' => $strMainID . '_price',
            'DSC_PERC' => $strMainID . '_dsc_perc',
            'SECOND_DSC_PERC' => $strMainID . '_second_dsc_perc',

            'PROP_DIV' => $strMainID . '_sku_tree',
            'PROP' => $strMainID . '_prop_',
            'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
            'BASKET_PROP_DIV' => $strMainID . '_basket_prop'
        );

        $strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

        $strTitle = (
        isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
            ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
            : $arItem['NAME']
        );
        $showImgClass = $arParams['SHOW_IMAGE'] != "Y" ? "no-imgs" : "";

        ?>
        <div class="<? echo($arItem['SECOND_PICT'] && $arParams ? 'bx_catalog_item double' : 'bx_catalog_item'); ?>"
             id="<? echo $strMainID; ?>">
        <div class="bx_catalog_item_container <? echo $showImgClass; ?>">
	<a id="<? echo $arItemIDs['PICT']; ?>" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"
       class="bx_catalog_item_images"<? if ($arParams['SHOW_IMAGE'] == "Y") {
        ?> style="background-image: url('<? echo($arParams['SHOW_IMAGE'] == "Y" ? $arItem['PREVIEW_PICTURE']['SRC'] : ""); ?>')"<?
    } ?> title="<? echo $strTitle; ?>"><?
        if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']) {
            ?>
            <div id="<? echo $arItemIDs['DSC_PERC']; ?>" class="bx_stick_disc right bottom"
                 style="display:<? echo(0 < $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] ? '' : 'none'); ?>;">
				-<? echo $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']; ?>%
			</div>
            <?
        }
        if ($arItem['LABEL']) {
            ?>
            <div class="bx_stick average left top"
                 title="<? echo $arItem['LABEL_VALUE']; ?>"><? echo $arItem['LABEL_VALUE']; ?></div><?
        }
        ?>
	</a><?
            if ($arItem['SECOND_PICT']) {
                ?><a id="<? echo $arItemIDs['SECOND_PICT']; ?>" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"
                     class="bx_catalog_item_images_double" <? if ($arParams['SHOW_IMAGE'] == "Y") {
                    ?> style="background-image: url('<? echo(
                    !empty($arItem['PREVIEW_PICTURE_SECOND'])
                        ? $arItem['PREVIEW_PICTURE_SECOND']['SRC']
                        : $arItem['PREVIEW_PICTURE']['SRC']
                    ); ?>')"<?
                } ?> title="<? echo $strTitle; ?>"><?
                if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']) {
                    ?>
                    <div id="<? echo $arItemIDs['SECOND_DSC_PERC']; ?>" class="bx_stick_disc right bottom"
                         style="display:<? echo(0 < $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] ? '' : 'none'); ?>;">
				-<? echo $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']; ?>%
			</div>
                    <?
                }
                if ($arItem['LABEL']) {
                    ?>
                    <div class="bx_stick average left top"
                         title="<? echo $arItem['LABEL_VALUE']; ?>"><? echo $arItem['LABEL_VALUE']; ?></div><?
                }
                ?>
                </a><?
            }
            ?>
            <? if ($arParams['SHOW_NAME'] == "Y") {
                ?>
                <div class="bx_catalog_item_title"><a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"
                                                      title="<? echo $arItem['NAME']; ?>"><? echo $arItem['NAME']; ?></a></div>
                <?
            } ?>
            <div class="bx_catalog_item_price">

		<div id="<? echo $arItemIDs['PRICE']; ?>" class="bx_price"><?
            if (!empty($arItem['MIN_PRICE'])) {
                if (isset($arItem['OFFERS']) && !empty($arItem['OFFERS'])) {
                    /*echo GetMessage(
                        'CVP_TPL_MESS_PRICE_SIMPLE_MODE',
                        array(
                            '#PRICE#' => $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'],
                            '#MEASURE#' => GetMessage(
                                'CVP_TPL_MESS_MEASURE_SIMPLE_MODE',
                                array(
                                    '#VALUE#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_RATIO'],
                                    '#UNIT#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_NAME']
                                )
                            )
                        )
                    );
                } else {*/
                    ?><div class="bx_price_temp"><? echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];?></div>
                    <?
                }
                if ('Y' == $arParams['SHOW_OLD_PRICE'] && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']) {
                    ?> <span
                            style="color: #a5a5a5;font-size: 12px;font-weight: normal;white-space: nowrap;text-decoration: line-through;"><? echo $arItem['MIN_PRICE']['PRINT_VALUE']; ?></span><?
                }
            }
            ?></div>

            </div>

        </div>
        </div>
    <? } ?>


        <div style="clear: both;"></div>

	</div>


	</div>


	</div>
	</span>
    <?
}

$frame->end();
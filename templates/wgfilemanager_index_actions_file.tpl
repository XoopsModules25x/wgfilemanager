<div class="btn-group btn-group-sm" role="group" aria-label="group_view">
    <{if $file.image}>
        <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#imgModal" data-bs-title="<{$file.name}>" data-bs-info="<{$file.real_url}>" title='<{$smarty.const._MA_WGFILEMANAGER_FILE_SHOWPREVIEW}>'><img src="<{$wgfilemanager_icon_bi_url}>eye.svg" alt="<{$smarty.const._MA_WGFILEMANAGER_FILE_SHOWPREVIEW}>"></a>
    <{elseif $file.pdf}>
        <a class='btn btn-sm btn-outline-primary' href='#' data-bs-toggle="modal" data-bs-target="#pdfModal" data-bs-title="<{$file.name}>" data-bs-info="<{$file.real_url}>" title='<{$smarty.const._MA_WGFILEMANAGER_FILE_SHOWPREVIEW}>'><img src="<{$wgfilemanager_icon_bi_url}>eye.svg" alt="<{$smarty.const._MA_WGFILEMANAGER_FILE_SHOWPREVIEW}>" ></a>
    <{/if}>
    <{if $permDownloadFileFromDir|default:false}>
        <a class="btn btn-sm btn-outline-primary" href='download.php?op=download&amp;file_id=<{$file.id|default:0}>' title='<{$smarty.const._MA_WGFILEMANAGER_FILE_DOWNLOAD}>'><img src="<{$wgfilemanager_icon_bi_url}>download.svg" alt="<{$smarty.const._MA_WGFILEMANAGER_FILE_DOWNLOAD}>" ></a>
        <a class='btn btn-sm btn-outline-primary' onclick="printFile('<{$file.print_url}>')" href='#' title='<{$smarty.const._PRINT}>'><img src="<{$wgfilemanager_icon_bi_url}>printer.svg" alt="<{$smarty.const._PRINT}>" ></a>
    <{/if}>
    <{if $showBtnDetails|default:false}>
        <a class='btn btn-sm btn-outline-primary' href='file.php?op=show&amp;file_id=<{$file.id}><{$params|default:''}>' title='<{$smarty.const._MA_WGFILEMANAGER_DETAILS}>'><img src="<{$wgfilemanager_icon_bi_url}>search.svg" alt="<{$smarty.const._MA_WGFILEMANAGER_DETAILS}>" ></a>
    <{/if}>
    <{if $useFavorites|default:false && $userUid|default:0 > 0}>
        <{if $file.favorite_id > 0}>
            <a class='btn btn-sm btn-outline-primary' href='file.php?op=favorite_unpin&amp;file_id=<{$file.id}>&amp;favorite_id=<{$file.favorite_id}><{$params|default:''}>' title='<{$smarty.const._MA_WGFILEMANAGER_FAVORITE_UNPIN}>'><img src="<{$wgfilemanager_icon_bi_url}>pin.svg" alt="<{$smarty.const._MA_WGFILEMANAGER_FAVORITE_UNPIN}>" ></a>
        <{else}>
            <a class='btn btn-sm btn-outline-primary' href='file.php?op=favorite_pin&amp;file_id=<{$file.id}>&amp;favorite_id=<{$file.favorite_id}><{$params|default:''}>' title='<{$smarty.const._MA_WGFILEMANAGER_FAVORITE_PIN}>'><img src="<{$wgfilemanager_icon_bi_url}>pin-angle.svg" alt="<{$smarty.const._MA_WGFILEMANAGER_FAVORITE_PIN}>" ></a>
        <{/if}>
    <{/if}>
</div>
<{if $permEditFile|default:false || $showBtnBack|default:false}>
    <div class="btn-group btn-group-sm" role="group" aria-label="group_view">
        <{if $permEditFile|default:false}>
            <a class="btn btn-sm btn-outline-primary" href='file.php?op=edit&amp;file_id=<{$file.id}><{$params|default:''}>' title='<{$smarty.const._EDIT}>'><img src="<{$wgfilemanager_icon_bi_url}>pencil-square.svg" alt="<{$smarty.const._EDIT}>" ></a>
            <a class="btn btn-sm btn-outline-danger" href='file.php?op=delete&amp;file_id=<{$file.id}><{$params|default:''}>' title='<{$smarty.const._DELETE}>'><img src="<{$wgfilemanager_icon_bi_url}>trash.svg" alt="<{$smarty.const._DELETE}>" ></a>
        <{/if}>
        <{if $useBroken|default:false}>
        <a class='btn btn-sm btn-outline-primary' href='file.php?op=broken&amp;file_id=<{$file.id}><{$params|default:''}>' title='<{$smarty.const._MA_WGFILEMANAGER_BROKEN}>'><img src="<{$wgfilemanager_icon_bi_url}>exclamation-circle.svg" alt="<{$smarty.const._MA_WGFILEMANAGER_BROKEN}>" ></a>
        <{/if}>
        <{if $showBtnBack|default:false}>
            <a class='btn btn-sm btn-outline-primary' href='index.php?op=list&amp;dir_id=<{$file.directory_id}><{$params|default:''}>' title='<{$smarty.const._BACK}>'><img src="<{$wgfilemanager_icon_bi_url}>arrow-return-left.svg" alt="<{$smarty.const._BACK}>" ></a>
        <{/if}>
    </div>
<{/if}>

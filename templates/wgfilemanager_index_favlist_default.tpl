<{if $fav_list|default:false}>
    <ul style="list-style-type: none;padding:0 0;">
        <li class="wgf-dirlist nav-link"><i class="bi-pin-angle"></i><{$smarty.const._MA_WGFILEMANAGER_FAVORITE}>
        <li class="wgf-dirlist nav-link">
            <ul style="list-style-type: none;padding:0 0;">
                <{foreach item=favdir from=$fav_list.dirs name=favdir}>
                    <li class="wgf-favlist d-flex mb-2 nav-link">
                        <div class="p-2"><a class='' href='<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$favdir.id}>' title='<{$favdir.name}>'><i class="bi-folder"></i><{$favdir.name}></a></div>
                        <div class="ms-auto p-2"><a class='' href='<{$wgfilemanager_url}>/directory.php?op=favorite_pin&amp;id=<{$favdir.id}>&amp;parent_id=<{$favdir.parent_id}>' title='<{$smarty.const._MA_WGFILEMANAGER_FAVORITE_UNPIN}>'><i class="bi-pin wgf-pin"></i></a></div>
                    </li>
                <{/foreach}>
                <{foreach item=favfile from=$fav_list.files name=favfile}>
                    <li class="wgf-favlist d-flex mb-2 nav-link">
                        <div class="p-2"><a class='' href='<{$wgfilemanager_url}>/file.php?op=show&file_id=<{$favfile.id}>&dir_id=<{$favfile.directory_id}>' title='<{$favfile.name}>'><i class="bi-file-earmark"></i><{$favfile.name}></a></div>
                        <div class="ms-auto p-2"><a class='' href='<{$wgfilemanager_url}>/file.php?op=favorite_unpin&amp;file_id=<{$favfile.id}>' title='<{$smarty.const._MA_WGFILEMANAGER_FAVORITE_UNPIN}>'><i class="bi-pin wgf-pin"></i></a></div>
                    </li>
                <{/foreach}>
            </ul>
        </li>
    </ul>
<{/if}>


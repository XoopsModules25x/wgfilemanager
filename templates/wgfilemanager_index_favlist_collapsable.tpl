<{if $countFavlist|default:0 > 0}>
    <div class="wgf-dirlist" id="collapseLevel0Fav">
        <div class="sb-sidenav-menu-nested nav">
            <div class="wgf-div-link">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseLevel1Fav" data-bs-toggle="collapse" data-bs-target="#collapseLevel1Fav" aria-expanded="false" aria-controls="collapseLevel1Fav">
                    <{$smarty.const._MA_WGFILEMANAGER_FAVORITE}><span class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down wgf-i"></i></span></a>
            </div>
            <div class="collapse" id="collapseLevel1Fav" aria-labelledby="headingone" data-bs-parent="#collapseLevel0Fav">
                <div class="sb-sidenav-menu-nested nav">
                    <{foreach item=favdir from=$fav_list.dirs name=favdir}>
                        <div class="">
                            <a style="display:inline-block;" class="nav-link wgf-favlist-link" href="<{$wgfilemanager_url}>/file.php?op=show&dir_id=<{$favdir.directory_id}>" title="<{$favdir.name}>">
                                <i class="bi-folder"></i><{$favdir.name}></a>
                            <a style="display:inline-block" class='nav-link pull-right' href='<{$wgfilemanager_url}>/directory.php?op=favorite_unpin&amp;id=<{$favdir.id}>&amp;favorite_id=<{$favdir.favorite_id}>&amp;parent_id=<{$favdir.parent_id}>' title='<{$smarty.const._MA_WGFILEMANAGER_FAVORITE_UNPIN}>'><i class="bi-pin wgf-pin"></i></a>
                        </div>
                    <{/foreach}>
                    <{foreach item=favfile from=$fav_list.files name=favfile}>
                        <div class="">
                            <a style="display:inline-block;" class="nav-link wgf-favlist-link" href="<{$wgfilemanager_url}>/file.php?op=show&file_id=<{$favfile.id}>&dir_id=<{$favfile.directory_id}>" title="<{$favfile.name}>">
                                <i class="bi-file-earmark"></i><{$favfile.name}></a>
                            <a style="display:inline-block" class='nav-link pull-right' href='<{$wgfilemanager_url}>/file.php?op=favorite_unpin&amp;file_id=<{$favfile.id}>&amp;favorite_id=<{$favfile.favorite_id}>' title='<{$smarty.const._MA_WGFILEMANAGER_FAVORITE_UNPIN}>'><i class="bi-pin wgf-pin"></i></a>
                        </div>
                    <{/foreach}>
                </div>
            </div>
        </div>
    </div>
<{/if}>
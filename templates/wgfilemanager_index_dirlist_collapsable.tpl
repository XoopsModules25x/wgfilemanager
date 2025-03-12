<div class="wgf-dirlist" id="collapseLevel0FM">
    <nav class="sb-sidenav-menu-nested nav">
        <{foreach item=dir1 from=$dir_list name=dir key=key1}>
            <{if $dir1.count_subdirs|default:0 > 0}>
                <div class="wgf-div-link">
                    <a style="display: inline;" class="nav-link collapsed <{if $dir1.highlight|default:false}> active<{/if}>" href="<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$dir1.id}>" title="<{$dir1.name}>">
                        <{if $dir1.state|default:'closed' == 'open'}><i class="bi-folder2-open"></i><{else}><i class="bi-folder"></i><{/if}>
                        <{$dir1.name|truncate:$lengthName:"...":true}></a>
                    <a style="display: inline;" class="nav-link collapsed <{if $dir1.highlight|default:false}> active<{/if}>" href="#" data-toggle="collapse" data-target="#collapseLevel1FM<{$key1}>" data-bs-toggle="collapse" data-bs-target="#collapseLevel1FM<{$key1}>" aria-expanded="false" aria-controls="collapseLevel1FM<{$key1}>">
                        <div class="sb-sidenav-collapse-arrow"><i class="wgf-i <{if $dir1.show|default:false}>fa fa-angle-left<{else}>fa fa-angle-down<{/if}>"></i></div></a>
                </div>
                <div class="collapse<{if $dir1.show|default:false}> show<{/if}>" id="collapseLevel1FM<{$key1}>" aria-labelledby="headingone" data-bs-parent="#collapseLevel0FM">
                    <nav class="sb-sidenav-menu-nested nav">
                        <{foreach item=dir2 from=$dir1.subdirs key=key2}>
                            <{if count($dir2.subdirs|default:[]) > 0}>
                                <div class="wgf-div-link">
                                    <a style="display: inline;" class="nav-link collapsed<{if $dir2.highlight|default:false}> active<{/if}>" href="<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$dir2.id}>" title="<{$dir2.name}>">
                                        <{if $dir2.state|default:'closed' == 'open'}><i class="bi-folder2-open"></i><{else}><i class="bi-folder"></i><{/if}>
                                        <{$dir2.name|truncate:$lengthName:"...":true}></a>
                                    <a style="display: inline;" class="nav-link collapsed<{if $dir2.highlight|default:false}> active<{/if}>" href="#" data-toggle="collapse" data-target="#collapseLevel2FM<{$key2}>" data-bs-toggle="collapse" data-bs-target="#collapseLevel2FM<{$key2}>" aria-expanded="false" aria-controls="collapseLevel2FM<{$key2}>">
                                        <div class="sb-sidenav-collapse-arrow"><i class="wgf-i <{if $dir2.show|default:false}>fa fa-angle-left<{else}>fa fa-angle-down<{/if}>"></i></div></a>
                                </div>
                                <div class="collapse<{if $dir2.show|default:false}> show<{/if}>" id="collapseLevel2FM<{$key2}>" aria-labelledby="headingtwo" data-bs-parent="#collapseLevel1FM<{$key1}>">
                                    <div class="sb-sidenav-menu-nested nav">
                                        <{foreach item=dir3 from=$dir2.subdirs key=key3}>
                                            <{if count($dir3.subdirs|default:[]) > 0}>
                                                <div class="wgf-div-link">
                                                    <a style="display: inline;" class="nav-link collapsed<{if $dir3.highlight|default:false}> active<{/if}>" href="<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$dir3.id}>" title="<{$dir3.name}>">
                                                        <{if $dir3.state|default:'closed' == 'open'}><i class="bi-folder2-open"></i><{else}><i class="bi-folder"></i><{/if}>
                                                        <{$dir3.name|truncate:$lengthName:"...":true}></a>
                                                    <a style="display: inline;" class="nav-link collapsed<{if $dir3.highlight|default:false}> active<{/if}>" href="#" data-toggle="collapse" data-target="#collapseLevel3FM<{$key3}>" data-bs-toggle="collapse" data-bs-target="#collapseLevel3FM<{$key3}>" aria-expanded="false" aria-controls="collapseLevel3FM<{$key3}>">
                                                        <div class="sb-sidenav-collapse-arrow"><i class="wgf-i <{if $dir2.show|default:false}>fa fa-angle-left<{else}>fa fa-angle-down<{/if}>"></i></div></a>
                                                </div>
                                                <div class="collapse<{if $dir3.show|default:false}> show<{/if}>" id="collapseLevel3FM<{$key3}>" aria-labelledby="headingthree" data-bs-parent="#collapseLevel2FM<{$key2}>">
                                                    <div class="sb-sidenav-menu-nested nav">
                                                        <{foreach item=dir4 from=$dir3.subdirs key=key4}>
                                                            <{if count($dir4.subdirs|default:[]) > 0}>
                                                                <div class="wgf-div-link">
                                                                    <a style="display: inline;" class="nav-link collapsed<{if $dir4.highlight|default:false}> active<{/if}>" href="<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$dir4.id}>" title="<{$dir4.name}>">
                                                                        <{if $dir4.state|default:'closed' == 'open'}><i class="bi-folder2-open"></i><{else}><i class="bi-folder"></i><{/if}>
                                                                        <{$dir4.name|truncate:$lengthName:"...":true}></a>
                                                                    <a style="display: inline;" class="nav-link collapsed<{if $dir4.highlight|default:false}> active<{/if}>" href="#" data-toggle="collapse" data-target="#collapseLevel4FM<{$key4}>" data-bs-toggle="collapse" data-bs-target="#collapseLevel4FM<{$key4}>" aria-expanded="false" aria-controls="collapseLevel4FM<{$key4}>">
                                                                        <div class="sb-sidenav-collapse-arrow"><i class="wgf-i <{if $dir3.show|default:false}>fa fa-angle-left<{else}>fa fa-angle-down<{/if}>"></i></div></a>
                                                                </div>
                                                                <div class="collapse<{if $dir4.show|default:false}> show<{/if}>" id="collapseLevel4FM<{$key4}>" aria-labelledby="headingfour" data-bs-parent="#collapseLevel3FM<{$key3}>">
                                                                    <nav class="sb-sidenav-menu-nested nav">
                                                                        <{foreach item=dir5 from=$dir4.subdirs key=key5}>
                                                                            <{if count($dir5.subdirs|default:[]) > 0}>
                                                                                <div class="wgf-div-link">
                                                                                    <a style="display: inline;" class="nav-link collapsed<{if $dir5.highlight|default:false}> active<{/if}>" href="<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$dir5.id}>" title="<{$dir5.name}>">
                                                                                        <{if $dir5.state|default:'closed' == 'open'}><i class="bi-folder2-open"></i><{else}><i class="bi-folder"></i><{/if}>
                                                                                        <{$dir5.name|truncate:$lengthName:"...":true}></a>
                                                                                    <a style="display: inline;" class="nav-link collapsed<{if $dir5.highlight|default:false}> active<{/if}>" href="#" data-toggle="collapse" data-target="#collapseLevel5FM<{$key5}>" data-bs-toggle="collapse" data-bs-target="#collapseLevel5FM<{$key5}>" aria-expanded="false" aria-controls="collapseLevel5FM<{$key5}>">
                                                                                        <div class="sb-sidenav-collapse-arrow"><i class=wgf-i "<{if $dir4.show|default:false}>fa fa-angle-left<{else}>fa fa-angle-down<{/if}>"></i></div></a>
                                                                                </div>
                                                                                <div class="collapse<{if $dir5.show|default:false}> show<{/if}>" id="collapseLevel5FM<{$key5}>" aria-labelledby="headingfive" data-bs-parent="#collapseLevel4FM<{$key4}>">
                                                                                    <div class="sb-sidenav-menu-nested nav">
                                                                                        <{foreach item=dir6 from=$dir5.subdirs key=key6}>
                                                                                            <{if count($dir6.subdirs|default:[]) > 0}>
                                                                                                <div class="wgf-div-link">
                                                                                                    <a style="display: inline;" class="nav-link collapsed<{if $dir6.highlight|default:false}> active<{/if}>" href="<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$dir6.id}>" title="<{$dir6.name}>">
                                                                                                        <{if $dir6.state|default:'closed' == 'open'}><i class="bi-folder2-open"></i><{else}><i class="bi-folder"></i><{/if}>
                                                                                                        <{$dir6.name|truncate:$lengthName:"...":true}></a>
                                                                                                    <a style="display: inline;" class="nav-link collapsed<{if $dir6.highlight|default:false}> active<{/if}>" href="#" data-toggle="collapse" data-target="#collapseLevel6FM<{$key6}>" data-bs-toggle="collapse" data-bs-target="#collapseLevel6FM<{$key6}>" aria-expanded="false" aria-controls="collapseLevel6FM<{$key6}>">
                                                                                                        <div class="sb-sidenav-collapse-arrow"><i class=wgf-i "<{if $dir5.show|default:false}>fa fa-angle-left<{else}>fa fa-angle-down<{/if}>"></i></div></a>
                                                                                                </div>
                                                                                                <div class="collapse<{if $dir6.show|default:false}> show<{/if}>" id="collapseLevel6FM<{$key6}>" aria-labelledby="headingsix" data-bs-parent="#collapseLevel5FM<{$key5}>">
                                                                                                    <div class="sb-sidenav-menu-nested nav">
                                                                                                        <{foreach item=dir7 from=$dir6.subdirs key=key7}>
                                                                                                            <{if count($dir7.subdirs|default:[]) > 0}>
                                                                                                                <div class="wgf-div-link">
                                                                                                                    <a style="display: inline;" class="nav-link collapsed<{if $dir7.highlight|default:false}> active<{/if}>" href="<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$dir7.id}>" title="<{$dir7.name}>">
                                                                                                                        <{if $dir7.state|default:'closed' == 'open'}><i class="bi-folder2-open"></i><{else}><i class="bi-folder"></i><{/if}>
                                                                                                                        <{$dir7.name|truncate:$lengthName:"...":true}></a>
                                                                                                                    <a style="display: inline;" class="nav-link collapsed<{if $dir7.highlight|default:false}> active<{/if}>" href="#" data-toggle="collapse" data-target="#collapseLevel7FM<{$key7}>" data-bs-toggle="collapse" data-bs-target="#collapseLevel7FM<{$key7}>" aria-expanded="false" aria-controls="collapseLevel7FM<{$key7}>">
                                                                                                                        <div class="sb-sidenav-collapse-arrow"><i class=wgf-i "<{if $dir6.show|default:false}>fa fa-angle-left<{else}>fa fa-angle-down<{/if}>"></i></div></a>
                                                                                                                </div>
                                                                                                                <div class="collapse<{if $dir7.show|default:false}> show<{/if}>" id="collapseLevel7FM<{$key7}>" aria-labelledby="headingsix" data-bs-parent="#collapseLevel6FM<{$key6}>">
                                                                                                                    <div class="sb-sidenav-menu-nested nav">
                                                                                                                        <{foreach item=dir8 from=$dir7.subdirs key=key8}>
                                                                                                                            <{if count($dir8.subdirs|default:[]) > 0}>
                                                                                                                                <div class="wgf-div-link">
                                                                                                                                    <a style="display: inline;" class="nav-link collapsed<{if $dir8.highlight|default:false}> active<{/if}>" href="<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$dir8.id}>" title="<{$dir8.name}>">
                                                                                                                                        <{if $dir8.state|default:'closed' == 'open'}><i class="bi-folder2-open"></i><{else}><i class="bi-folder"></i><{/if}>
                                                                                                                                        <{$dir8.name|truncate:$lengthName:"...":true}></a>
                                                                                                                                    <a style="display: inline;" class="nav-link collapsed<{if $dir8.highlight|default:false}> active<{/if}>" href="#" data-toggle="collapse" data-target="#collapseLevel8FM<{$key8}>" data-bs-toggle="collapse" data-bs-target="#collapseLevel8FM<{$key8}>" aria-expanded="false" aria-controls="collapseLevel8FM<{$key8}>">
                                                                                                                                        <div class="sb-sidenav-collapse-arrow"><i class=wgf-i "<{if $dir7.show|default:false}>fa fa-angle-left<{else}>fa fa-angle-down<{/if}>"></i></div></a>
                                                                                                                                </div>
                                                                                                                                <div class="collapse<{if $dir8.show|default:false}> show<{/if}>" id="collapseLevel8FM<{$key8}>" aria-labelledby="headingsix" data-bs-parent="#collapseLevel7FM<{$key7}>">
                                                                                                                                    <div class="sb-sidenav-menu-nested nav">
                                                                                                                                        <{foreach item=dir9 from=$dir8.subdirs key=key9}>
                                                                                                                                            <{if count($dir9.subdirs|default:[]) > 0}>
                                                                                                                                                <div class="wgf-div-link">
                                                                                                                                                    <a style="display: inline;" class="nav-link collapsed<{if $dir9.highlight|default:false}> active<{/if}>" href="<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$dir9.id}>" title="<{$dir9.name}>">
                                                                                                                                                        <{if $dir9.state|default:'closed' == 'open'}><i class="bi-folder2-open"></i><{else}><i class="bi-folder"></i><{/if}>
                                                                                                                                                        <{$dir9.name|truncate:$lengthName:"...":true}></a>
                                                                                                                                                    <a style="display: inline;" class="nav-link collapsed<{if $dir9.highlight|default:false}> active<{/if}>" href="#" data-toggle="collapse" data-target="#collapseLevel9FM<{$key9}>" data-bs-toggle="collapse" data-bs-target="#collapseLevel9FM<{$key9}>" aria-expanded="false" aria-controls="collapseLevel9FM<{$key9}>">
                                                                                                                                                        <div class="sb-sidenav-collapse-arrow"><i class=wgf-i "<{if $dir8.show|default:false}>fa fa-angle-left<{else}>fa fa-angle-down<{/if}>"></i></div></a>
                                                                                                                                                </div>
                                                                                                                                            <{else}>
                                                                                                                                                <a class="nav-link<{if $dir9.highlight|default:false}> active<{/if}>" href="<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$dir9.id}>" title="<{$dir9.name}>">
                                                                                                                                                    <{if $dir9.state|default:'closed' == 'open'}><i class="bi-folder2-open"></i><{else}><i class="bi-folder"></i><{/if}>
                                                                                                                                                    <{$dir9.name|truncate:$lengthName:"...":true}></a>
                                                                                                                                            <{/if}>
                                                                                                                                        <{/foreach}>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            <{else}>
                                                                                                                                <a class="nav-link<{if $dir8.highlight|default:false}> active<{/if}>" href="<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$dir8.id}>" title="<{$dir8.name}>">
                                                                                                                                    <{if $dir8.state|default:'closed' == 'open'}><i class="bi-folder2-open"></i><{else}><i class="bi-folder"></i><{/if}>
                                                                                                                                    <{$dir8.name|truncate:$lengthName:"...":true}></a>
                                                                                                                            <{/if}>
                                                                                                                        <{/foreach}>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            <{else}>
                                                                                                                <a class="nav-link<{if $dir7.highlight|default:false}> active<{/if}>" href="<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$dir7.id}>" title="<{$dir7.name}>">
                                                                                                                    <{if $dir7.state|default:'closed' == 'open'}><i class="bi-folder2-open"></i><{else}><i class="bi-folder"></i><{/if}>
                                                                                                                    <{$dir7.name|truncate:$lengthName:"...":true}></a>
                                                                                                            <{/if}>
                                                                                                        <{/foreach}>
                                                                                                    </div>
                                                                                                </div>
                                                                                            <{else}>
                                                                                                <a class="nav-link<{if $dir6.highlight|default:false}> active<{/if}>" href="<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$dir6.id}>" title="<{$dir6.name}>">
                                                                                                    <{if $dir6.state|default:'closed' == 'open'}><i class="bi-folder2-open"></i><{else}><i class="bi-folder"></i><{/if}>
                                                                                                    <{$dir6.name|truncate:$lengthName:"...":true}></a>
                                                                                            <{/if}>
                                                                                        <{/foreach}>
                                                                                    </div>
                                                                                </div>
                                                                            <{else}>
                                                                                <a class="nav-link<{if $dir5.highlight|default:false}> active<{/if}>" href="<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$dir5.id}>" title="<{$dir5.name}>">
                                                                                    <{if $dir5.state|default:'closed' == 'open'}><i class="bi-folder2-open"></i><{else}><i class="bi-folder"></i><{/if}>
                                                                                    <{$dir5.name|truncate:$lengthName:"...":true}></a>
                                                                            <{/if}>
                                                                        <{/foreach}>
                                                                    </nav>
                                                                </div>
                                                            <{else}>
                                                                <a class="nav-link<{if $dir4.highlight|default:false}> active<{/if}>" href="<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$dir4.id}>" title="<{$dir4.name}>">
                                                                    <{if $dir4.state|default:'closed' == 'open'}><i class="bi-folder2-open"></i><{else}><i class="bi-folder"></i><{/if}>
                                                                    <{$dir4.name|truncate:$lengthName:"...":true}></a>
                                                            <{/if}>
                                                        <{/foreach}>
                                                    </div>
                                                </div>
                                            <{else}>
                                                <a class="nav-link<{if $dir3.highlight|default:false}> active<{/if}>" href="<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$dir3.id}>" title="<{$dir3.name}>">
                                                    <{if $dir3.state|default:'closed' == 'open'}><i class="bi-folder2-open"></i><{else}><i class="bi-folder"></i><{/if}>
                                                    <{$dir3.name|truncate:$lengthName:"...":true}></a>
                                            <{/if}>
                                        <{/foreach}>
                                    </div>
                                </div>
                            <{else}>
                                <a class="nav-link<{if $dir2.highlight|default:false}> active<{/if}>" href="<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$dir2.id}>" title="<{$dir2.name}>">
                                    <{if $dir2.state|default:'closed' == 'open'}><i class="bi-folder2-open"></i><{else}><i class="bi-folder"></i><{/if}>
                                    <{$dir2.name|truncate:$lengthName:"...":true}></a>
                            <{/if}>
                        <{/foreach}>
                    </nav>
                </div>
            <{else}>
                <a class="nav-link<{if $dir1.highlight|default:false}> active<{/if}>" href="<{$dir1.url}>" title="<{$dir1.name}>">
                    <{if $dir1.state|default:'closed' == 'open'}><i class="bi-folder2-open"></i><{else}><i class="bi-folder"></i><{/if}>
                    <{$dir1.name|truncate:$lengthName:"...":true}></a>
            <{/if}>
        <{/foreach}>
    </nav>
</div>

<{if count($dir_list|default:[]) > 0}>
    <ul style="list-style-type: none;<{if $dir.id|default:0 == 0}>padding:0 0;<{/if}>">
        <{foreach item=dir from=$dir_list name=dir}>
            <li class="wgf-dirlist <{if $dir.level|default:0 == 1}>wgf-dirlist-default-level1<{/if}>">
                <{if $dir.state|default:'closed' == 'open'}>
                    <a class='nav-link active fw-bold' href='<{$wgfilemanager_url}>/index.php?op?list&amp;dir_id=<{$dir.id}>' title='<{$dir.name}>'><i class="bi-folder2-open"></i>
                        <{$dir.name|truncate:$lengthName:"...":true}></a>
                <{else}>
                    <a class='nav-link ' href='<{$wgfilemanager_url}>/index.php?op=list&amp;dir_id=<{$dir.id}>' title='<{$dir.name}>'><i class="bi-folder"></i>
                        <{$dir.name|truncate:$lengthName:"...":true}></a>
                <{/if}>
                <{if $dir.count_subdirs > 0}>
                    <{include file='db:wgfilemanager_index_dirlist_default.tpl' dir_list=$dir.subdirs}>
                <{/if}>
            </li>
        <{/foreach}>
    </ul>
<{/if}>


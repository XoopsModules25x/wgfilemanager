<!-- Header -->
<{include file='db:wgfilemanager_admin_header.tpl' }>

<{if $favorite_list|default:''}>
    <table class='table table-bordered'>
        <thead>
            <tr class='head'>
                <th class="center"><{$smarty.const._AM_WGFILEMANAGER_FAVORITE_ID}></th>
                <th class="center"><{$smarty.const._MA_WGFILEMANAGER_DIRECTORY}></th>
                <th class="center"><{$smarty.const._MA_WGFILEMANAGER_FILE}></th>
                <th class="center"><{$smarty.const._AM_WGFILEMANAGER_FAVORITE_DATE_CREATED}></th>
                <th class="center"><{$smarty.const._MA_WGFILEMANAGER_FAVORITE_SUBMITTER}></th>
                <th class="center width5"><{$smarty.const._MA_WGFILEMANAGER_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $favorite_count|default:''}>
        <tbody>
            <{foreach item=favorite from=$favorite_list}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$favorite.id|default:false}></td>
                <td class='center'>
                    <{if $favorite.directory_id|default:0 > 0}>
                        (<{$favorite.directory_id|default:0}>) <{$favorite.dir_name|default:false}></td>
                    <{/if}>
                <td class='center'>
                    <{if $favorite.file_id|default:0 > 0}>
                        (<{$favorite.file_id|default:0}>) <{$favorite.file_name|default:false}></td>
                    <{/if}>
                </td>
                <td class='center'><{$favorite.date_created_text|default:false}></td>
                <td class='center'><{$favorite.submitter_text|default:false}></td>
                <td class="center  width5">
                    <a href="favorite.php?op=delete&amp;id=<{$favorite.id|default:false}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 'delete.png'}>" alt="<{$smarty.const._DELETE}> favorite" ></a>
                </td>
            </tr>
            <{/foreach}>
        </tbody>
        <{/if}>
    </table>
    <div class="clear">&nbsp;</div>
    <{if $pagenav|default:''}>
        <div class="xo-pagenav floatright"><{$pagenav|default:false}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>
<{if $form|default:''}>
    <{$form|default:false}>
<{/if}>
<{if $error|default:''}>
    <div class="errorMsg"><strong><{$error|default:false}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wgfilemanager_admin_footer.tpl' }>

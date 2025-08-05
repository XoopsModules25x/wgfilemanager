<{include file='db:wgfilemanager_header.tpl' }>

<{if $fileShow|default:false}>
<div class='table-responsive'>
    <table class='table table-<{$table_type|default:false}>'>
        <thead>
            <tr class='head'>
                <th colspan="2"><{$smarty.const._MA_WGFILEMANAGER_FILE_DETAILS}></th>
            </tr>
        </thead>
        <tbody>
            <{if $file.image|default:false}>
                <tr>
                    <td class="center" colspan="2">
                        <img class="card-img-top center wgf-preview-<{$file.category|default:0}>" src="<{$file.real_url}>" alt="<{$file.name}>">
                    </td>
                </tr>
            <{/if}>
            <tr>
                <td><{$smarty.const._MA_WGFILEMANAGER_FILE_NAME}></td>
                <td><{$file.name|default:false}></td>
            </tr>
            <{if $file.description_text|default:false}>
                <tr>
                    <td><{$smarty.const._MA_WGFILEMANAGER_FILE_DESCRIPTION}></td>
                    <td><{$file.description_text|default:false}></td>
                </tr>
            <{/if}>
            <{if $file.directory_id|default:0 > 1}>
                <tr>
                    <td><{$smarty.const._MA_WGFILEMANAGER_FILE_DIRECTORY_ID}></td>
                    <td><{$file.dir_fullpath|default:false}></td>
                </tr>
            <{/if}>
            <tr>
                <td><{$smarty.const._MA_WGFILEMANAGER_FILE_MTIME}></td>
                <td><{$file.mtime_text|default:false}></td>
            </tr>
            <tr>
                <td><{$smarty.const._MA_WGFILEMANAGER_FILE_CTIME}></td>
                <td><{$file.ctime_text|default:false}></td>
            </tr>
            <tr>
                <td><{$smarty.const._MA_WGFILEMANAGER_FILE_SIZE}></td>
                <td><{$file.size_text|default:false}></td>
            </tr>
            <tr>
                <td><{$smarty.const._MA_WGFILEMANAGER_FILE_MIMETYPE}></td>
                <td><{$file.mimetype|default:false}></td>
            </tr>
            <tr>
                <td><{$smarty.const._MA_WGFILEMANAGER_FILE_IP}></td>
                <td><{$file.ip|default:false}></td>
            </tr>
            <tr>
                <td><{$smarty.const._MA_WGFILEMANAGER_FILE_DATE_CREATED}></td>
                <td><{$file.date_created_text|default:false}></td>
            </tr>
            <tr>
                <td><{$smarty.const._MA_WGFILEMANAGER_FILE_SUBMITTER}></td>
                <td><{$file.submitter_text|default:false}></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="center"><{include file='db:wgfilemanager_index_actions_file.tpl' }></td>
            </tr>
        </tfoot>
    </table>
</div>
<{/if}>
<{if $form|default:''}>
    <{$form|default:false}>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadInput = document.getElementById('fil_name');

            if (uploadInput) {
                uploadInput.addEventListener('change', function() {
                    const file = this.files[0];

                    if (file) {
                        const filename = file.name;
                        const dotCount = (filename.match(/\./g) || []).length;

                        if (dotCount > 1) {
                            alert("<{$smarty.const._MA_WGFILEMANAGER_FORM_UPLOAD_MULTIDOTS}>");
                        }
                    }
                });
            }
        });
    </script>
<{/if}>
<{if $error|default:''}>
    <{$error|default:false}>
<{/if}>

<{include file='db:wgfilemanager_footer.tpl' }>

<{include file='db:wgfilemanager_modal.tpl' }>
<{include file='db:wgfilemanager_print.tpl' }>

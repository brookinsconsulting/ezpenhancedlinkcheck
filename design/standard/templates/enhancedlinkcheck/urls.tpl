{* Website URLs View *}
{ezcss_require('demo_table.css', 'demo_table_jui.css')}
<div class="context-block">
    <div class="box-header">
        <div class="box-ml">
                {* <h1 class="context-title">URLs ({$list_count|l10n('number')|explode('.00')|implode('')} entries)</h1> *}
                        <h1 class="context-title">URLs</h1>
            <div class="header-mainline"></div>
        </div>
    </div>
    <div class="box-content">
        <table class="datatable list" cellspacing="0">
        <colgroup>
            <col width="40%" />
            <col width="10%" />
            <col width="10%" />
            <col width="5%" />
            <col width="15%" />
            <col width="15%" />
            <col width="5%" />
        </colgroup>
        <thead>
            <tr>
                <th>{'Address'|i18n('design/admin/url/list')}</th>
                <th>Subtree</th>
                <th>State</th>
                <th>{'Status'|i18n('design/admin/url/list')}</th>
                <th>{'Checked'|i18n('design/admin/url/list')}</th>
                <th>{'Modified'|i18n('design/admin/url/list')}</th>
                <th class="tight">&nbsp;</th>
            </tr>
        </thead>
        </table>
    </div>
</div>
<script type="text/javascript" src={'javascript/jquery.dataTables.min.js'|ezdesign()}></script>
{literal}
<script type="text/javascript">
    jQuery(function(){
        jQuery('.datatable').dataTable({
                    aoColumns: [
                        null,
                        null,
                        null,
                        null,
                        { "sType": "date" },
                        { "sType": "date" },
                        null
                    ],
            bProcessing: true,
            bServerSide: true,
            sAjaxSource: '/enhancedlinkcheck/urllist',
            sPaginationType: 'full_numbers',
{/literal}
{if ezgetvars()['sSearch']}
                        "oSearch": {literal}{"sSearch": "{/literal}{ezgetvars()['sSearch']}{literal}"}{/literal},
{/if}
{if ezgetvars()['offset']}
                        iDisplayStart: {ezgetvars()['offset']},
{/if}
{if ezgetvars()['limit']}
                        iDisplayLength: {ezgetvars()['limit']},
{else}
            iDisplayLength: 25,
{/if}
{literal}
            aLengthMenu: [10, 25, 50, 100, 250]
        });
    });
</script>
{/literal}
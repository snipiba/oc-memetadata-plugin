function injectMetadataButtons(retries = 10) {
    
    const tableRows = $('tr[data-type="media-item"]:not(.metadata-patched):is([data-document-type="image"]');
    const gridItems = $('li[data-type="media-item"]:not(.metadata-patched):is([data-document-type="image"]')

    const anyFound = tableRows.length > 0 || gridItems.length > 0;
    if (!anyFound) {
        if (retries <= 0) return;
        return setTimeout(() => injectMetadataButtons(retries - 1), 200);
    }

    const listId = 'MediaManager-manager-item-list';

    // tabulkový layout (list view)
    tableRows.each(function () {
        const row = $(this);
        const path = row.data('path');
        const type = row.data('item-type') || 'file';
        const titleCell = row.find('.item-title');

        if (!path || titleCell.length === 0) return;

        const btn = $('<a />')
            .attr({
                href: '#',
                title: 'Update metadata',
                style: 'margin-right: 30px',
                'data-metadata': '',
                'data-control': 'popup',
                'data-request-data': `path: '${path}', listId: '${listId}', type: '${type}'`,
                'data-handler': 'manager::onLoadMetadataPopup',
                'data-z-index': 1205,
                'data-size': 'huge'
            })
            .html('<i class="icon-pencil"></i>');

        titleCell.append(btn);
        row.addClass('metadata-patched');
    });

    // mozaikový layout (grid view)
    gridItems.each(function () {
        const item = $(this);
        const path = item.data('path');
        const type = item.data('item-type') || 'file';
        const titleWrapper = item.find('.info h4');

        if (!path || titleWrapper.length === 0) return;

        const btn = $('<a />')
            .attr({
                href: '#',
                style: 'margin-right: 30px',
                title: 'Update metadata',
                'data-metadata': '',
                'data-control': 'popup',
                'data-request-data': `path: '${path}', listId: '${listId}', type: '${type}'`,
                'data-handler': 'manager::onLoadMetadataPopup',
                'data-z-index': 1205,
                'data-size': 'huge'
            })
            .html('<i class="icon-pencil"></i>');

        titleWrapper.append(btn);
        item.addClass('metadata-patched');
    });
}

$(document).on('render.oc.mediaManager', function () {
    injectMetadataButtons();
    attachMetadataSidebarEnhancer();
});


    function attachMetadataSidebarEnhancer() {
        const labelPanel = $('[data-control="sidebar-labels"]');
        if (labelPanel.length === 0) return;

        const path = $('[data-control="sidebar-thumbnail"]').data('path');
        if (!path) return;

        // Odstráň staré metadáta (ak existujú)
        labelPanel.find('[data-meta-injected]').remove();

        // Získaj metadata zo servera
        $.request('onGetMediaMetadata', {
            data: { path: path },
            success: function (data) {
                if (!data.meta) return;

                const table = labelPanel.find('table.name-value-list');
                if (!table.length) return;

                const block = $(`
                    <tbody data-meta-injected>
                        <tr>
                            <td colspan="2">
                                <h5 style="margin: 8px 0 4px; font-weight: 600;">Media Metadata</h5>
                            </td>
                        </tr>
                        ${data.meta.title ? `
                        <tr>
                            <th>Title</th>
                            <td>${data.meta.title}</td>
                        </tr>` : ''}
                        ${data.meta.author ? `
                        <tr>
                            <th>Description</th>
                            <td>${data.meta.description}</td>
                        </tr>` : ''}
                        ${data.meta.author ? `
                        <tr>
                            <th>Autor</th>
                            <td>${data.meta.author_url
                                ? `<a href="${data.meta.author_url}" target="_blank" rel="noopener" class="external-link">${data.meta.author}</a>`
                                : data.meta.author}</td>
                        </tr>` : ''}
                        ${data.meta.source ? `
                        <tr>
                            <th>Zdroj</th>
                            <td>${data.meta.source_url
                                ? `<a href="${data.meta.source_url}" target="_blank" rel="noopener" class="external-link">${data.meta.source}</a>`
                                : data.meta.source}</td>
                        </tr>` : ''}
                        ${data.meta.source ? `
                        <tr>
                            <th>Keywords</th>
                            <td>${data.meta.keywords}</td>
                        </tr>` : ''}
                    </tbody>
                `);

                table.after(block);
            }
        });
    }
    


define([
    'jquery',
    'Magento_Ui/js/grid/columns/column',
    'mage/template',
    'Magento_Ui/js/modal/modal',
    'text!Blackbird_RestLogger/templates/grid/cells/payload.html'
], function ($, Column, mageTemplate, Modal, payloadTemplate) {
    'use strict';
    return Column.extend({
        defaults: {
            bodyTmpl: 'ui/grid/cells/text',
            fieldClass: {
                'data-grid-html-cell': true,
                'payload-action': true
            }
        },
        getPayload: function(row) {
            return row['full_payload'];
        },
        getEndpoint: function(row) {
            return row['endpoint'];
        },
        getResponse: function(row) {
            return row['response_code'];
        },
        preview: function(row) {
            let modalHtml = mageTemplate(
                payloadTemplate, {
                    payload: this.getPayload(row),
                    endpoint: this.getEndpoint(row),
                    response: this.getResponse(row)
                }
            );
            let payloadModal = $('<div/>').html(modalHtml);
            payloadModal.modal({
                title: 'Details',
                innerScroll: true,
                buttons: [{
                    text: $.mage.__('Close'),
                    class: '',
                    click: function () {
                        this.closeModal();
                    }
                }]
            }).trigger('openModal');
        },
        getFieldHandler: function(row) {
            return this.preview.bind(this, row);
        }
    });
});

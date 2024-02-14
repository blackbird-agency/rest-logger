define([
    'jquery',
    'Magento_Ui/js/grid/columns/column',
    'mage/template',
    'Magento_Ui/js/modal/modal',
    'text!Blackbird_RestLogger/templates/grid/cells/details.html'
], function ($, Column, mageTemplate, Modal, payloadTemplate) {
    'use strict';
    return Column.extend({
        defaults: {
            bodyTmpl: 'ui/grid/cells/text',
            fieldClass: {
                'data-grid-html-cell': true,
                'details-action': true
            }
        },
        getPayload: function(row) {
            return row['payload_full'];
        },
        getEndpoint: function(row) {
            return row['endpoint'];
        },
        getResponse: function(row) {
            return row['response_code'];
        },
        getResponseBody: function(row) {
            return row['response_body_full'];
        },
        preview: function(row) {
            let modalHtml = mageTemplate(
                payloadTemplate, {
                    payload: this.getPayload(row),
                    payload_active: this.getPayload(row)?.length !== 0,
                    endpoint: this.getEndpoint(row),
                    response: this.getResponse(row),
                    response_active: this.getResponse(row)?.length !== 0,
                    response_body: this.getResponseBody(row)
                }
            );
            let payloadModal = $('<div/>').html(modalHtml);
            payloadModal.modal({
                title: 'Details',
                innerScroll: true,
                modalClass: 'rest-details',
                buttons: [{
                    text: $.mage.__('Close'),
                    class: '',
                    click: function () {
                        this.closeModal();
                    }
                }]
            }).trigger('contentUpdated').trigger('openModal');
        },
        getFieldHandler: function(row) {
            return this.preview.bind(this, row);
        }
    });
});

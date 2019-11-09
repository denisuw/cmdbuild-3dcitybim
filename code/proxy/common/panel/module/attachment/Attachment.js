(function () {

	Ext.define('CMDBuild.proxy.common.panel.module.attachment.Attachment', {

		uses: [
			'CMDBuild.core.constants.Proxy',
			'CMDBuild.model.common.panel.module.attachment.Attachment',
			'CMDBuild.model.common.panel.module.attachment.window.Lookup',
			'CMDBuild.proxy.common.panel.module.attachment.reader.Lookup',
			'CMDBuild.proxy.index.Json'
		],

		singleton: true,

		/**
		 * @param {Object} parameters
		 *
		 * @returns {Void}
		 */
		download: function (parameters) {
			parameters = Ext.isObject(parameters) ? parameters : {};

			if (Ext.isObject(parameters.params) && !Ext.Object.isEmpty(parameters.params))
				window.open(
					CMDBuild.proxy.index.Json.attachment.download + '?' + Ext.urlEncode(parameters.params),
					'_blank'
				);
		},
		/*EDIT BY AYAW*/
		openPopUp: function (parameters) {
			parameters = Ext.isObject(parameters) ? parameters : {};

			if (Ext.isObject(parameters.params) && !Ext.Object.isEmpty(parameters.params))
			{
				var url = CMDBuild.proxy.index.Json.attachment.download + '?' + Ext.urlEncode(parameters.params);
				var x = Ext.create("Ext.Window",{
					title : 'Attachment',
					width : 1000,
					height: 500,
					html : '<div style="width:1000px;height:500px;"><img src="'+url+'" height="500" width="1000"></div>',
					tbar : [{
						text : record.raw.fileName ,
						handler :function(){
							// I disable the parent window.
							x.disable();

						}
					}]
				}).show();
			}
		},
		/*EDIT BY AYAW */

		/**
		 * @returns {Ext.data.Store or CMDBuild.core.cache.Store}
		 */
		getStore: function () {
			return CMDBuild.global.Cache.requestAsStore(CMDBuild.core.constants.Proxy.UNCACHED, { // Uncached because update doesn't go through cache component
				autoLoad: false,
				model: 'CMDBuild.model.common.panel.module.attachment.Attachment',
				groupField: CMDBuild.core.constants.Proxy.CATEGORY,
				proxy: {
					type: 'ajax',
					url: CMDBuild.proxy.index.Json.attachment.readAll,
					reader: {
						type: 'json',
						root: CMDBuild.core.constants.Proxy.RESPONSE
					},
					extraParams: { // Avoid to send limit, page and start parameters in server calls
						limitParam: undefined,
						pageParam: undefined,
						startParam: undefined
					}
				},
				sorters: [
					{ property: CMDBuild.core.constants.Proxy.CATEGORY, direction: 'ASC' },
					{ property: CMDBuild.core.constants.Proxy.CREATION, direction: 'ASC' }
				]
			});
		},

		/**
		 * @returns {Ext.data.Store or CMDBuild.core.cache.Store}
		 *
		 * FIXME: waiting for refactor (rename)
		 */
		getStoreLokup: function () {
			return CMDBuild.global.Cache.requestAsStore(CMDBuild.core.constants.Proxy.LOOKUP, {
				autoLoad: false,
				model: 'CMDBuild.model.common.panel.module.attachment.window.Lookup',
				proxy: {
					type: 'ajax',
					url: CMDBuild.proxy.index.Json.lookup.readAll,
					reader: {
						type: 'lookupstore',
						root: CMDBuild.core.constants.Proxy.ROWS
					},
					extraParams: { // Avoid to send limit, page and start parameters in server calls
						limitParam: undefined,
						pageParam: undefined,
						startParam: undefined,

						// Custom params
						active: true,
						short: true,
						type: CMDBuild.configuration.dms.get(CMDBuild.core.constants.Proxy.ALFRESCO_LOOKUP_CATEGORY)
					},
					actionMethods: 'POST' // Lookup types can have UTF-8 names not handled correctly
				},
				sorters: [
					{ property: CMDBuild.core.constants.Proxy.NUMBER, direction: 'ASC' },
					{ property: CMDBuild.core.constants.Proxy.DESCRIPTION, direction: 'ASC' }
				]
			});
		},

		/**
		 * @param {Object} parameters
		 *
		 * @returns {Void}
		 */
		readAttachmentContext: function (parameters) {
			parameters = Ext.isEmpty(parameters) ? {} : parameters;

			Ext.apply(parameters, { url: CMDBuild.proxy.index.Json.attachment.getContext });

			CMDBuild.global.Cache.request(CMDBuild.core.constants.Proxy.ATTACHMENT, parameters);
		},

		/**
		 * @param {Object} parameters
		 *
		 * @returns {Void}
		 */
		remove: function (parameters) {
			parameters = Ext.isEmpty(parameters) ? {} : parameters;

			Ext.apply(parameters, { url: CMDBuild.proxy.index.Json.attachment.remove });

			CMDBuild.global.Cache.request(CMDBuild.core.constants.Proxy.ATTACHMENT, parameters, true);
		}
	});

})();

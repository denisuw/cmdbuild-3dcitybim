(function () {

	/**
	 * Required managed functions from upper structure:
	 * 	- panelGridAndFormPanelFormTemplateResolverFormGet
	 * 	- panelGridAndFormSelectedEntityGet
	 * 	- panelGridAndFormSelectedEntityIsEmpty
	 * 	- panelGridAndFormSelectedItemGet
	 * 	- panelGridAndFormSelectedItemIsEmpty
	 *
	 * @abstract
	 */
	Ext.define('CMDBuild.controller.common.panel.module.attachment.Grid', {
		extend: 'CMDBuild.controller.common.abstract.Base',

		uses: [
			'CMDBuild.core.constants.Global',
			'CMDBuild.core.constants.Proxy',
			'CMDBuild.core.LoadMask',
			'CMDBuild.core.Message',
			'CMDBuild.proxy.common.panel.module.attachment.Attachment'
		],

		/**
		 * @cfg {Object}
		 */
		parentDelegate: undefined,

		/**
		 * @property {Object}
		 *
		 * @private
		 */
		categories: {},

		/**
		 * @cfg {Array}
		 */
		cmfgCatchedFunctions: [
			'onPanelModuleAttachmentGridAddButtonClick',
			'onPanelModuleAttachmentGridDownloadButtonClick',
			'onPanelModuleAttachmentGridPopUpButtonClick',
			'onPanelModuleAttachmentGridModifyButtonClick',
			'onPanelModuleAttachmentGridRemoveButtonClick',
			'onPanelModuleAttachmentGridVersionsButtonClick',
			'panelModuleAttachmentGridBorderBottomSet',
			'panelModuleAttachmentGridCategoriesIsEmpty',
			'panelModuleAttachmentGridCategoriesGet',
			'panelModuleAttachmentGridReadAttachmentContext',
			'panelModuleAttachmentGridReset',
			'panelModuleAttachmentGridStoreLoad',
		],

		/**
		 * @property {CMDBuild.controller.common.panel.module.attachment.Versions}
		 */
		controllerVersions: undefined,

		/**
		 * @property {CMDBuild.controller.common.panel.module.attachment.window.Add}
		 */
		controllerWindowAdd: undefined,

		/**
		 * @property {CMDBuild.controller.common.panel.module.attachment.window.Modify}
		 */
		controllerWindowModify: undefined,

		/**
		 * @property {CMDBuild.view.common.panel.module.attachment.GridPanel}
		 */
		view: undefined,

		/**
		 * @param {Object} configurationObject
		 * @param {Object} configurationObject.parentDelegate
		 *
		 * @returns {Void}
		 *
		 * @override
		 */
		constructor: function (configurationObject) {
			this.callParent(arguments);

			this.view = Ext.create('CMDBuild.view.common.panel.module.attachment.GridPanel', { delegate: this });

			// Build sub-controllers
			this.controllerVersions = Ext.create('CMDBuild.controller.common.panel.module.attachment.Versions', { parentDelegate: this });
			this.controllerWindowAdd = Ext.create('CMDBuild.controller.common.panel.module.attachment.window.Add', { parentDelegate: this });
			this.controllerWindowModify = Ext.create('CMDBuild.controller.common.panel.module.attachment.window.Modify', { parentDelegate: this });
		},

		/**
		 * Adapter to be compatible with TemplateResolver
		 *
		 * @returns {Object}
		 *
		 * @legacy
		 * @private
		 */
		getTemplateResolverServerVars: function () {
			return Ext.apply({
				'Id': this.cmfg('panelGridAndFormSelectedItemGet', CMDBuild.core.constants.Proxy.ID),
				'IdClass': this.cmfg('panelGridAndFormSelectedItemGet', CMDBuild.core.constants.Proxy.CLASS_ID),
				'IdClass_value': this.cmfg('panelGridAndFormSelectedItemGet', CMDBuild.core.constants.Proxy.CLASS_DESCRIPTION)
			}, this.cmfg('panelGridAndFormSelectedItemGet', CMDBuild.core.constants.Proxy.VALUES));
		},

		/**
		 * @returns {Void}
		 */
		onPanelModuleAttachmentGridAddButtonClick: function () {
			// Error handling
				if (this.cmfg('panelGridAndFormSelectedItemIsEmpty', CMDBuild.core.constants.Proxy.ID))
					return CMDBuild.core.Message.error(
						CMDBuild.Translation.common.failure,
						CMDBuild.Translation.warnings.canNotAddAnAttachmentBeforeSavingTheActivity,
						false
					);
			// END: Error handling

			var mergedRoules = mergeRulesInASingleMap(
				this.cmfg('panelGridAndFormSelectedEntityGet', [
					CMDBuild.core.constants.Proxy.META,
					CMDBuild.core.constants.Proxy.ATTACHMENTS,
					CMDBuild.core.constants.Proxy.AUTOCOMPLETION
				])
			);

			new CMDBuild.Management.TemplateResolver({
				clientForm: this.cmfg('panelGridAndFormPanelFormTemplateResolverFormGet'),
				xaVars: mergedRoules,
				serverVars: this.getTemplateResolverServerVars()
			}).resolveTemplates({
				attributes: Ext.Object.getKeys(mergedRoules),
				scope: this,
				callback: function (out, ctx) {
					this.controllerWindowAdd.cmfg('panelModuleAttachmentWindowAddConfigureAndShow', { presets: groupMergedRules(out) });
				}
			});
		},

		/**
		 * @param {CMDBuild.model.common.panel.module.attachment.Attachment} record
		 *
		 * @returns {Void}
		 */
		onPanelModuleAttachmentGridDownloadButtonClick: function (record) {
			// Error handling
				if (!Ext.isObject(record) || Ext.Object.isEmpty(record))
					return _error('onPanelModuleAttachmentGridDownloadButtonClick(): unmanaged record parameter', this, record);
			// END: Error handling

			var params = {};
			params[CMDBuild.core.constants.Proxy.CARD_ID] = this.cmfg('panelGridAndFormSelectedItemGet', CMDBuild.core.constants.Proxy.ID);
			params[CMDBuild.core.constants.Proxy.CLASS_NAME] = this.cmfg('panelGridAndFormSelectedEntityGet', CMDBuild.core.constants.Proxy.NAME);
			params[CMDBuild.core.constants.Proxy.FILE_NAME] = record.get(CMDBuild.core.constants.Proxy.FILE_NAME);
			
			CMDBuild.proxy.common.panel.module.attachment.Attachment.download({ params: params });
		},
		/**
		 EDIT BY AYAW
		 */
		onPanelModuleAttachmentGridPopUpButtonClick: function (record) {
			// Error handling
				if (!Ext.isObject(record) || Ext.Object.isEmpty(record))
					return _error('onPanelModuleAttachmentGridPopUpButtonClick(): unmanaged record parameter', this, record);
			// END: Error handling

			var params = {};
			params[CMDBuild.core.constants.Proxy.CARD_ID] = this.cmfg('panelGridAndFormSelectedItemGet', CMDBuild.core.constants.Proxy.ID);
			params[CMDBuild.core.constants.Proxy.CLASS_NAME] = this.cmfg('panelGridAndFormSelectedEntityGet', CMDBuild.core.constants.Proxy.NAME);
			params[CMDBuild.core.constants.Proxy.FILE_NAME] = record.get(CMDBuild.core.constants.Proxy.FILE_NAME);
			
			CMDBuild.proxy.common.panel.module.attachment.Attachment.openPopUp({ params: params });
		},
		/**
		 * @param {CMDBuild.model.common.panel.module.attachment.Attachment} record
		 *
		 * @returns {Void}
		 */
		onPanelModuleAttachmentGridModifyButtonClick: function (record) {
			// Error handling
				if (!Ext.isObject(record) || Ext.Object.isEmpty(record))
					return _error('onPanelModuleAttachmentGridModifyButtonClick(): unmanaged record parameter', this, record);
			// END: Error handling

			this.controllerWindowModify.cmfg('panelModuleAttachmentWindowModifyConfigureAndShow', { record: record });
		},

		/**
		 * @param {CMDBuild.model.common.panel.module.attachment.Attachment} record
		 *
		 * @returns {Void}
		 */
		onPanelModuleAttachmentGridRemoveButtonClick: function (record) {
			Ext.Msg.show({
				title: CMDBuild.Translation.common.confirmpopup.title,
				msg: CMDBuild.Translation.common.confirmpopup.areyousure,
				buttons: Ext.Msg.YESNO,
				scope: this,

				fn: function (buttonId, text, opt) {
					if (buttonId == 'yes')
						this.removeItem(record);
				}
			});
		},

		/**
		 * @param {CMDBuild.model.common.panel.module.attachment.Attachment} record
		 *
		 * @returns {Void}
		 */
		onPanelModuleAttachmentGridVersionsButtonClick: function (record) {
			// Error handling
				if (!Ext.isObject(record) || Ext.Object.isEmpty(record))
					return _error('onPanelModuleAttachmentGridVersionsButtonClick(): unmanaged record parameter', this, record);
			// END: Error handling

			this.controllerVersions.cmfg('panelModuleAttachmentVersionsConfigureAndShow', { record: record });
		},

		/**
		 * @param {Boolean} enable
		 *
		 * @returns {Void}
		 */
		panelModuleAttachmentGridBorderBottomSet: function (enable) {
			enable = Ext.isBoolean(enable) ? enable : false;

			if (enable)
				return this.view.addCls('cmdb-border-bottom');

			return this.view.removeCls('cmdb-border-bottom');
		},

		// Categories property functions
			/**
			 * @param {Object} parameters
			 * @param {String} parameters.name
			 *
			 * @returns {CMDBuild.model.common.panel.module.attachment.category.Category or Object}
			 */
			panelModuleAttachmentGridCategoriesGet: function (parameters) {
				parameters = Ext.isObject(parameters) ? parameters : {};

				if (Ext.isString(parameters.name) && !Ext.isEmpty(parameters.name))
					return this.categories[parameters.name];

				return this.categories;
			},

			/**
			 * @param {Object} parameters
			 * @param {String} parameters.name
			 *
			 * @returns {Boolean}
			 */
			panelModuleAttachmentGridCategoriesIsEmpty: function (parameters) {
				parameters = Ext.isObject(parameters) ? parameters : {};

				if (Ext.isString(parameters.name) && !Ext.isEmpty(parameters.name))
					return Ext.isEmpty(this.categories[parameters.name]);

				return true;
			},

			/**
			 * @returns {Void}
			 *
			 * @private
			 */
			panelModuleAttachmentCategoriesReset: function () {
				this.categories = {};
			},

			/**
			 * @param {Array} categories
			 *
			 * @returns {Void}
			 *
			 * @private
			 */
			panelModuleAttachmentCategoriesSet: function (categories) {
				this.panelModuleAttachmentCategoriesReset();

				if (Ext.isArray(categories) && !Ext.isEmpty(categories))
					Ext.Array.forEach(categories, function (categoryObject, i, allCategoryObjects) {
						if (Ext.isObject(categoryObject) && !Ext.Object.isEmpty(categoryObject)) {
							var model = Ext.create('CMDBuild.model.common.panel.module.attachment.category.Category', categoryObject);

							this.categories[model.get(CMDBuild.core.constants.Proxy.NAME)] = model;
						}
					}, this);
			},

		/**
		 * @param {Object} parameters
		 * @param {Function} parameters.callback
		 * @param {Object} parameters.scope
		 *
		 * @returns {Void}
		 */
		panelModuleAttachmentGridReadAttachmentContext: function (parameters) {
			parameters = Ext.isObject(parameters) ? parameters : {};
			parameters.callback = Ext.isFunction(parameters.callback) ? parameters.callback : Ext.emptyFn;
			parameters.scope = Ext.isObject(parameters.scope) ? parameters.scope : this;

			CMDBuild.proxy.common.panel.module.attachment.Attachment.readAttachmentContext({
				loadMask: false,
				scope: this,
				success: function (response, options, decodedResponse) {
					decodedResponse = decodedResponse[CMDBuild.core.constants.Proxy.RESPONSE];
					decodedResponse = decodedResponse[CMDBuild.core.constants.Proxy.CATEGORIES];

					this.panelModuleAttachmentCategoriesReset();

					if (Ext.isArray(decodedResponse) && !Ext.isEmpty(decodedResponse))
						this.panelModuleAttachmentCategoriesSet(decodedResponse);

					Ext.callback(parameters.callback, parameters.scope);
				}
			});
		},

		/**
		 * @returns {Void}
		 */
		panelModuleAttachmentGridReset: function () {
			this.view.getStore().removeAll();
		},

		/**
		 * @returns {Void}
		 */
		panelModuleAttachmentGridStoreLoad: function () {
			var params = {};
			params[CMDBuild.core.constants.Proxy.CARD_ID] = this.cmfg('panelGridAndFormSelectedItemGet', CMDBuild.core.constants.Proxy.ID);
			params[CMDBuild.core.constants.Proxy.CLASS_NAME] = this.cmfg('panelGridAndFormSelectedItemGet', CMDBuild.core.constants.Proxy.CLASS_NAME);

			this.view.getStore().load({ params: params });
		},

		/**
		 * @param {CMDBuild.model.common.panel.module.attachment.Attachment} record
		 *
		 * @returns {Void}
		 *
		 * @private
		 */
		removeItem: function (record) {
			// Error handling
				if (!Ext.isObject(record) || Ext.Object.isEmpty(record))
					return _error('onPanelModuleAttachmentGridDownloadButtonClick(): unmanaged record parameter', this, record);
			// END: Error handling

			var params = {};
			params[CMDBuild.core.constants.Proxy.CARD_ID] = this.cmfg('panelGridAndFormSelectedItemGet', CMDBuild.core.constants.Proxy.ID);
			params[CMDBuild.core.constants.Proxy.CLASS_NAME] = this.cmfg('panelGridAndFormSelectedItemGet', CMDBuild.core.constants.Proxy.CLASS_NAME);
			params[CMDBuild.core.constants.Proxy.FILE_NAME] = record.get(CMDBuild.core.constants.Proxy.FILE_NAME);

			CMDBuild.proxy.common.panel.module.attachment.Attachment.remove({
				params: params,
				scope: this,
				success: function (response, options, decodedResponse) {
					this.cmfg('panelModuleAttachmentGridStoreLoad');
				}
			});
		}
	});

	/**
	 * The template resolver want the templates as a map. Our rules are grouped so I need to merge them to have a single level map
	 * To avoid name collision I choose to concatenate the group name and the meta-data name
	 * The following two routines do this dirty work
	 *
	 * @legacy
	 *
	 * FIXME: refactor
	 */
	function mergeRulesInASingleMap(rules) {
		rules = rules || {};

		var out = {};

		for (var groupName in rules) {
			var group = rules[groupName];

			for (var key in group) {
				out[groupName + '_' + key] = group[key];
			}
		}

		return out;
	}

	/**
	 * @legacy
	 *
	 * FIXME: refactor
	 */
	function groupMergedRules(mergedRules) {
		var out = {};

		for (var key in mergedRules) {
			var group = null,
				metaName = null;

			try {
				var s = key.split('_');
				group = s[0];
				metaName = s[1];
			} catch (e) {
				// Pray for my soul
			}

			if (group && metaName) {
				out[group] = out[group] || {};
				out[group][metaName] = mergedRules[key];
			}
		}

		return out;
	}

})();

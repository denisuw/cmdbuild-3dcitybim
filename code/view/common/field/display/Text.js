(function () {

	Ext.define('CMDBuild.view.common.field.display.Text', {
		extend: 'Ext.form.FieldContainer',

		mixins: ['Ext.form.field.Field'], // To enable functionalities restricted to Ext.form.field.Field classes (loadRecord, etc.)

		/**
		 * @property {CMDBuild.controller.common.field.display.Text}
		 */
		delegate: undefined,

		/**
		 * @cfg {Boolean}
		 */
		allowBlank: true,

		/**
		 * @property {CMDBuild.core.buttons.iconized.Expand}
		 */
		detailsButton: undefined,

		/**
		 * @property {Ext.form.field.Display}
		 */
		displayField: undefined,

		/**
		 * Height limit where enable detailsButton
		 *
		 * @cfg {Number}
		 */
		maxHeight: 100,

		/**
		 * @cfg {Number}
		 */
		width: "100%",

		layout: {
			type: 'hbox',
			align: 'stretch'
		},

		/**
		 * @returns {Void}
		 *
		 * @override
		 */
		initComponent: function () {
		console.log(this);
			if(this.fieldLabel == "FileName")
			{
				Ext.apply(this, {
					delegate: Ext.create('CMDBuild.controller.common.field.display.Text', { view: this }),
					items: [
						this.detailsButton = Ext.create('CMDBuild.core.buttons.iconized.Export', {
							style: {
								background: 'none'
							},
							text: '',
							border: false,
							scope: this,
							hidden: true,

							handler: function (button, e) {
							
								this.delegate.cmfg('onFieldDisplayPanoDetailsButtonClick');
							}
						}),
						this.displayField = Ext.create('Ext.form.field.Display', {
							name: this.name,
							allowBlank: this.allowBlank,
							flex: 1
						})
					]
				});
			}
			if(this.fieldLabel == "CCTVUrl")
			{
				Ext.apply(this, {
					delegate: Ext.create('CMDBuild.controller.common.field.display.Text', { view: this }),
					items: [
						this.detailsButton = Ext.create('CMDBuild.core.buttons.iconized.Export', {
							style: {
								background: 'none'
							},
							text: '',
							border: false,
							scope: this,
							hidden: true,

							handler: function (button, e) {
							
								this.delegate.cmfg('onFieldDisplayCCTVButtonClick');
							}
						}),
						this.displayField = Ext.create('Ext.form.field.Display', {
							name: this.name,
							allowBlank: this.allowBlank,
							flex: 1
						})
					]
				});
			}
			else
			{
				Ext.apply(this, {
					delegate: Ext.create('CMDBuild.controller.common.field.display.Text', { view: this }),
					items: [
						this.detailsButton = Ext.create('CMDBuild.core.buttons.iconized.Expand', {
							style: {
								background: 'none'
							},
							text: '',
							border: false,
							scope: this,
							hidden: true,

							handler: function (button, e) {
							
								this.delegate.cmfg('onFieldDisplayTextDetailsButtonClick');
							}
						}),
						this.displayField = Ext.create('Ext.form.field.Display', {
							name: this.name,
							allowBlank: this.allowBlank,
							flex: 1
						})
					]
				});
			}
			this.detailsButton.show(); 
			this.callParent(arguments);
		},

		/**
		 * Forward method
		 *
		 * @returns {String}
		 */
		getRawValue: function() {
		console.log(this.delegate.cmfg('onFieldDisplayTextRawValueGet'));
			return this.delegate.cmfg('onFieldDisplayTextRawValueGet');
		},

		/**
		 * Forwarder method
		 *
		 * @returns {String}
		 *
		 * @override
		 */
		getValue: function () {
		console.log(this.delegate.cmfg('onFieldDisplayTextValueGet'));
			return this.delegate.cmfg('onFieldDisplayTextValueGet');
		},

		/**
		 * Forwarder method
		 *
		 * @returns {Boolean}
		 *
		 * @override
		 */
		isValid: function () {
			return this.delegate.cmfg('onFieldDisplayTextValueIsValid');
		},

		/**
		 * Forwarder method
		 *
		 * @returns {Void}
		 *
		 * @override
		 */
		reset: function () {
			this.delegate.cmfg('onFieldDisplayTextReset');
		},

		/**
		 * @param {String or Object} value
		 *
		 * @returns {Void}
		 *
		 * @override
		 */
		setValue: function (value) {
			this.delegate.cmfg('onFieldDisplayTextValueSet', value);
		}
	});

})();

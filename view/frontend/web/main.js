// 2017-09-17
/** 2017-09-06 @uses Class::extend() https://github.com/magento/magento2/blob/2.2.0-rc2.3/app/code/Magento/Ui/view/base/web/js/lib/core/class.js#L106-L140 */	
define(['Df_Payment/withOptions'], function(parent) {'use strict'; return parent.extend({
	/**
	 * 2017-09-17
	 * The `true` value means that the payment options need to be shown on the Magento side.
	 * The `false` value means that the payment options need to be shown on the Yandex.Kassa side.
	 * @returns {Boolean}
	 */
	needShowOptions: function() {return this.config('needShowOptions');},
});});
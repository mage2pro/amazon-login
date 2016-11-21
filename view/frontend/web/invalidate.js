// 2016-06-06
define([
	'jquery', 'df', 'Magento_Customer/js/customer-data'
], function($, df, customerData) {return (
	/**
	 * @param {Object} config
	 * @returns void
	 */
	function(config) {
		if ($.cookieStorage.get('df_need_update_customer_data')) {
			customerData.reload(['customer'], true);
			// 2016-06-07
			// https://github.com/julien-maurel/jQuery-Storage-API#remove
			$.cookieStorage.remove('df_need_update_customer_data');
		}
	});
});
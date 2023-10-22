jQuery(document).ready(function () {
	function send_ajax_request(nonce) {
		jQuery.ajax({
			type: "post",
			dataType: "json",
			url: rocketWpcAjax.ajaxurl,
			data: {action: "handle_crawl_now", nonce: nonce},
			complete: function (response) {
				document.location.reload();
			}
		});
	}

	jQuery("#rocket_wpc_action_btn").click(function(e){
		e.preventDefault();
		jQuery(this).attr('disabled', true);
		let nonce = jQuery(this).attr("data-nonce");
		if (jQuery(this).attr('data-action') === 'unscheduled' && confirm("Are you sure you want to unscheduled the crawler cron?") === true) {
			send_ajax_request(nonce);
		} else {
			send_ajax_request(nonce);
		}
	});
});

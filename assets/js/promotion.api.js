var api = {
	constant : {
		// hostUrl : 'http://dev.clout.com:8888/ajax/',
	  hostUrl : config_api.constant.hostUrl,
	  get: 'get/',
	  post: 'post/'
	},
	req : function(action,method,data,done,beforeSend,complete) {
		$.ajax({
			method: method,
			url: api.constant.hostUrl+action, 
			data:data,
			headers: {
				"Content-Type": "application/json"
			},
			success:function(result){
				done(result)
			},
			error: function(res){
				console.log('ERROR');
			},
			beforeSend: beforeSend,
			complete: complete
		});
	},
	get: function(action,data,done,beforeSend,complete){
		api.req(api.constant.get + action,'GET',data,done,beforeSend,complete);
	},
	post: function(action,data,done,beforeSend,complete){
		api.req(api.constant.post + action,'POST',data,done,beforeSend,complete);
	}
};

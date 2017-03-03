Data API :
```json
{
	"success":true,
	"status_code":200,
	"message":null,
	"data":{
		"items":[{
			"id":2,
			"title":"User",
			"created_at":"2016-11-28 02:54:27",
			"updated_at":"2016-11-28 02:54:27",
			"uid":"user"
			},
			{
				"id":1,"title":"Admin",
				"created_at":"2016-11-28 02:54:24",
				"updated_at":"2016-11-28 02:54:24",
				"uid":"admin"}
			],
			"_meta":{
			"current_page":1,
			"last_page":1,
			"from":1,
			"to":2,
			"per_page":10,"page_count":2},
			"links":{"next_link":null,"last_link":null}},
			"extra":[]
}
```
With: 
+ success: status (success/fails)
+ status_code: status code( 200 : OK, 401,...)
+ message: message attach 
+ data: data response

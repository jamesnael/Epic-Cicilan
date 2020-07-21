    var Ziggy = {
        namedRoutes: {"users.table":{"uri":"users\/table","methods":["GET","HEAD"],"domain":null},"users.data":{"uri":"users\/{users}\/data","methods":["GET","HEAD"],"domain":null},"users.index":{"uri":"users","methods":["GET","HEAD"],"domain":null},"users.create":{"uri":"users\/create","methods":["GET","HEAD"],"domain":null},"users.store":{"uri":"users","methods":["POST"],"domain":null},"users.edit":{"uri":"users\/{user}\/edit","methods":["GET","HEAD"],"domain":null},"users.update":{"uri":"users\/{user}","methods":["PUT","PATCH"],"domain":null},"users.destroy":{"uri":"users\/{user}","methods":["DELETE"],"domain":null},"reward-category.table":{"uri":"reward-category\/table","methods":["GET","HEAD"],"domain":null},"reward-category.data":{"uri":"reward-category\/{reward_category}\/data","methods":["GET","HEAD"],"domain":null},"reward-category.index":{"uri":"reward-category","methods":["GET","HEAD"],"domain":null},"reward-category.create":{"uri":"reward-category\/create","methods":["GET","HEAD"],"domain":null},"reward-category.store":{"uri":"reward-category","methods":["POST"],"domain":null},"reward-category.edit":{"uri":"reward-category\/{reward_category}\/edit","methods":["GET","HEAD"],"domain":null},"reward-category.update":{"uri":"reward-category\/{reward_category}","methods":["PUT","PATCH"],"domain":null},"reward-category.destroy":{"uri":"reward-category\/{reward_category}","methods":["DELETE"],"domain":null},"agencies.table":{"uri":"agencies\/table","methods":["GET","HEAD"],"domain":null},"agencies.data":{"uri":"agencies\/{agency}\/data","methods":["GET","HEAD"],"domain":null},"agencies.index":{"uri":"agencies","methods":["GET","HEAD"],"domain":null},"agencies.create":{"uri":"agencies\/create","methods":["GET","HEAD"],"domain":null},"agencies.store":{"uri":"agencies","methods":["POST"],"domain":null},"agencies.edit":{"uri":"agencies\/{agency}\/edit","methods":["GET","HEAD"],"domain":null},"agencies.update":{"uri":"agencies\/{agency}","methods":["PUT","PATCH"],"domain":null},"agencies.destroy":{"uri":"agencies\/{agency}","methods":["DELETE"],"domain":null},"sales.table":{"uri":"sales\/table","methods":["GET","HEAD"],"domain":null},"sales.data":{"uri":"sales\/{agency}\/data","methods":["GET","HEAD"],"domain":null},"sales.index":{"uri":"sales","methods":["GET","HEAD"],"domain":null},"sales.create":{"uri":"sales\/create","methods":["GET","HEAD"],"domain":null},"sales.store":{"uri":"sales","methods":["POST"],"domain":null},"sales.edit":{"uri":"sales\/{sales}\/edit","methods":["GET","HEAD"],"domain":null},"sales.update":{"uri":"sales\/{sales}","methods":["PUT","PATCH"],"domain":null},"sales.destroy":{"uri":"sales\/{sales}","methods":["DELETE"],"domain":null}},
        baseUrl: 'http://localhost/',
        baseProtocol: 'http',
        baseDomain: 'localhost',
        basePort: false,
        defaultParameters: []
    };

    if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
        for (var name in window.Ziggy.namedRoutes) {
            Ziggy.namedRoutes[name] = window.Ziggy.namedRoutes[name];
        }
    }

    export {
        Ziggy
    }

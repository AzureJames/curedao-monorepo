function notFoundBox(searchId) {
    if(!searchId){searchId = "no-table";}
	var el = document.getElementById(searchId + '-not-found-box');
	if(el){return el;}
	el = getElementOrError('no-search-id-provided-not-found-box');
	return el;
}
function apiResultsBox() {
	var el = document.getElementById('variables');
	if(el){return el;}
	el = document.getElementById('variables-api-results');
	if(el){return el;}
	el = getElementOrError('no-search-id-provided-api-results');
    return el;
}
function getElementOrError(searchId) {
    var el = document.getElementById(searchId);
    if (!el) {qmLog.errorAndExceptionTestingOrDevelopment("no " + searchId)}
    return el;
}
function debounce(func, timeout = 300){
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => { func.apply(this, args); }, timeout);
    };
}
function variableSearchFilter(){
    debounce(searchFilterRaw());
}
function fixFavicon(v){
    v.imageUrl = v.imageUrl.replace('https://i.olsh.me/icon?url=', 'https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url=https://');
    v.imageUrl = v.imageUrl.replace('80..120..200', '32');
}
function getSearchInput(){
    var input = document.getElementById('variables-input');
    if(input){input = input.value;}
    if(!input || !input.length){
        input = qm.urlHelper.getParam("q");
    }
    if(!input || !input.length){
        return ''
    }
    input = input.toUpperCase();
    return input;
}

function addSearchingNotification(searchId, input) {
	let htmlElement = apiResultsBox(searchId)
	if(!htmlElement){
		console.error("No api results box for " + searchId)
	}
	htmlElement.innerHTML = '<a href="">' +
	                        '    <div class="flex justify-center items-center m-1 font-large py-1 px-2 bg-white rounded-full text-purple-700 bg-purple-100 border border-purple-300 ">' +
	                        '       <div slot="avatar">' +
	                        '           <div class="flex relative w-4 h-4 bg-orange-500 justify-center items-center m-1 mr-2 ml-0 my-0 text rounded-full">' +
	                        '             <ion-icon name="search">' +
	                        //'             <img class="rounded-full" alt="A"
	                        // src="https://image.flaticon.com/icons/png/512/3208/3208746.png">' +
	                        '        </div>' +
	                        '       </div>' +
	                        '           <div class="text font-normal leading-none max-w-full flex-initial">' +
	                        '          Searching... ' +
	                        '        </div>' +
	                        '    </div>' +
	                        '</a>';
    console.log("searching for " + input);
}

function searchFilterRaw(searchId) {
    //debugger
    var searching = document.getElementById('searching-pill');
    var input = getSearchInput();
    var listId = 'variables-list';
    var ul = document.getElementById(listId);
    var items = ul.getElementsByTagName('a');
    addSearchingNotification(searchId, input);
    qm.commonVariablesHelper.getFromLocalStorageOrApi({searchPhrase: input})
        .then(function (variables){
            ul.innerHtml = "";
            //debugger
            var html = ""
            if(!variables.length && !input.length){
                variables = qm.staticData.commonVariables
            }
            variables = qm.arrayHelper.sortByProperty(variables, 'numberOfCorrelations', 'desc');
            variables.map(function (v){
                if(!v.url || v.url === "undefined"){
                    qmLog.error("no url was on: ", v)
                    v.url = window.location.href+"/"+v.id;
                }
                if(window.location.href.indexOf("quantim.do") === -1){
                    v.url = v.url.replace("https://app.quantimo.do", "https://studies.curedao.org");
                }
                fixFavicon(v)
                function addPillHtml() {
                    var ionIcon = v.ionIcon.replace('ion-', '').replace('ios-', '').replace('android-', '');
                    if(ionIcon === "fork"){ionIcon = "fast-food"}
                    if(ionIcon === "laptop"){ionIcon = "laptop-outline"}
                    if(ionIcon === "partlysunny"){ionIcon = "partly-sunny-outline"}
                    //if(v.variableCategoryName === "Environment"){ionIcon = "rainy"}
                    var iconHtml = '<ion-icon name="' + ionIcon + '"></ion-icon>';
                    if(variables.length < 20){
                        iconHtml = '<img class="rounded-full" alt="A" src="' + v.imageUrl + '">'
                    }
					var dataSearch = v.name;
					if(v.synonyms){
						if(Array.isArray(v.synonyms)){
							dataSearch += ", " + v.synonyms.join(", ");
						} else {
							dataSearch += ", " + v.synonyms;
						}
					}
                    html += //'<li><a href="'+v.url+'">'+v.name+'</a></li>' +
                        '<a href="' + v.url + '" title="' + v.subtitle + '" data-search="' + dataSearch + '">' +
                        '    <div class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-full text-purple-700 bg-purple-100 border border-purple-300 ">' +
                        '                    <div slot="avatar">' +
                        '                <div class="flex relative w-4 h-4 bg-orange-500 justify-center items-center m-1 mr-2 ml-0 my-0 text rounded-full">' +
                        iconHtml +
                        //
                        //'                    <i class="rounded-full ' + v.fontAwesome + '"></i>' +

                        //'<ion-icon name="heart"></ion-icon> '+
                        '                </div>' +
                        '            </div>' +
                        '                <div class="text font-normal leading-none max-w-full flex-initial">' +
                        '            ' + v.name +
                        '                            <span style="font-size: 0.6rem;" class="badge rounded-full px-1 py-1 text-center object-right-top bg-white border border-purple-300">' +
                        '                   ' + v.numberOfMeasurements +
                        '                </span>' +
                        '                    </div>' +
                        '    </div>' +
                        '</a>';
                }
				try {
					addPillHtml();
				} catch (e) {
					debugger
					qmLog.error(e);
				}
            })
	        debugger
            console.log(html)
	        let htmlElement = apiResultsBox(searchId)
	        htmlElement.innerHTML = html
        });
    toggleNotFound();
    hideItems();
    if(searching){searching.style.display = "block";}
    function toggleNotFound() {
        if(!input){return;}
        var notFound = notFoundBox(searchId);
        if(searching){searching.style.display = "none";}
        if (notFound) {
            if (input.length > 2) {
                notFound.style.display = "";
            } else {
                notFound.style.display = "none";
            }
        }
    }
    function hideItems() {
        [...items].forEach(function (item){
            var txtValue = item.textContent || item.innerText;
            if(item.__x_for && item.__x_for.item && item.__x_for.item.keywords){
                txtValue = item.__x_for.item.keywords
            }
            if (txtValue.toUpperCase().indexOf(input) > -1) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
            //document.querySelector("#variables-api-results > a:nth-child(12) > div > div:nth-child(1) > div > img")
        })
        // Loop through all list items, and hide those who don't match the search query
        // for (var i = 0; i < items.length; i++) {
        //     var item = items[i];
        //     var txtValue = item.textContent || item.innerText;
        //     if(item.__x_for && item.__x_for.item && item.__x_for.item.keywords){
        //         txtValue = item.__x_for.item.keywords
        //     }
        //     if (txtValue.toUpperCase().indexOf(input) > -1) {
        //         item.style.display = "";
        //     } else {
        //         item.style.display = "none";
        //     }
        // }
    }
}
$( document ).ready(function() {
    var varsStr = JSON.stringify(qm.staticData.commonVariables)
    varsStr = varsStr.replace(/local.quantimo.do/g, window.location.host);
    qm.staticData.commonVariables = JSON.parse(varsStr)
    model={variables:qm.staticData.commonVariables}
    console.log( "ready!" );
    searchFilterRaw('variables');
});
var model = {};

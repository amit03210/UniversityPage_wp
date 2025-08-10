class LiveSearch {

    // 1. objects initialization
    constructor(){
        this.searchFunctionalityJS();
        this.searchOverlay = document.querySelector(".search-overlay");
        this.searchText = document.querySelector(".search-term");
        this.closeSearch = document.querySelector(".close-search");
        this.searchIcon = document.querySelectorAll('.js-search-trigger');
        this.resultWindow = document.querySelector('.search-overlay__result');
        this.spinnerIcon = document.querySelector('.spinner-icon');
        this.inputTag = document.querySelector('input');
        this.isOverlay = false;
        this.isSpinnerLoaded = false;
        this.previousValue;
        this.timeOut;
        this.event();
    }

    //2. Events or Connecting HTML with method.
    event(){
        this.searchIcon.forEach(ele => ele.addEventListener('click', this.addOverlay.bind(this)));
        this.closeSearch.addEventListener('click', this.removeOverlay.bind(this));
        document.querySelector("body").addEventListener('keydown', this.keyDownAddOverlay.bind(this));
        document.querySelector("body").addEventListener('keydown', this.keyDownRemoveOverlay.bind(this));
        this.searchText.addEventListener('keyup', this.textLogic.bind(this));
         
    }

    // 3. Methods / action ...
    addOverlay(e){
        this.searchText.value = "";
        document.querySelector('body').classList.add("body-no-scroll");
        this.searchOverlay.classList.add("search-overlay--active");
        setTimeout(() => this.searchText.focus(), 301);
        this.isOverlay = true;
        e.preventDefault();

    }
    
    removeOverlay(){
        this.searchOverlay.classList.remove("search-overlay--active");
        document.querySelector('body').classList.remove("body-no-scroll");
        this.isOverlay = false;
    }

    keyDownAddOverlay(e){
        const activeTag = document.activeElement.tagName;
        if(e.key == "s" && !this.isOverlay && activeTag !== "INPUT" && activeTag !== "TEXTAREA" && activeTag !== "P"){
            this.addOverlay();
        }
    }

    keyDownRemoveOverlay(e){
        if(e.key == "Escape" && this.isOverlay){
            this.removeOverlay();
        }
    }

    textLogic(){
        // clear previous setTimeout() except for last keydown event trigger
        if(this.previousValue != this.searchText.value){
            clearTimeout(this.timeOut);
            
            //if input box not empty
            if(this.searchText.value){ 
                if(!this.isSpinnerLoaded){
                    this.isSpinnerLoaded = true;
                    this.resultWindow.innerHTML = '<div class="spinner-loader"></div>';
                }
                this.timeOut = setTimeout(this.resultOutput.bind(this), 500);
            }
            //if input box empty
            else{
                this.isSpinnerLoaded = false;
                this.resultWindow.innerHTML = "";
            }
        }
        this.previousValue = this.searchText.value;
        }

    resultOutput(){
        const url = universityData['root_url'] + "//wp-json/university/v2/talaash?keyword=" + this.searchText.value;

        fetch(url)
        .then(res => res.json())
        .then(result => {
            console.log(result);
            this.resultWindow.innerHTML = 
           `<div class='root'>
                <div class='one-third'>
                    <h2 class="search-overlay__section-title">General Information</h2>
                    ${result.generalInfo.length == 0? 'Result not available': "<ul class='min-list link-list'>" +
                        result.generalInfo.map(post => `<li><a href=${post.url}'>${post.title}</a> ${post.type == 'post'? 'by ' + post.author:""}</li>`).join('') + '</ul>'}
                </div>
                <div class='one-third'>
                    <h2 class="search-overlay__section-title">Programs</h2>
                    ${result.programs.length == 0? 'Result not available': "<ul class='min-list link-list'>" +
                        result.programs.map(post => `<li><a href=${post.url}'>${post.title}</a></li>`).join('') + '</ul>'}
        
                    <h2 class="search-overlay__section-title">Professors</h2>
                     ${result.professors.length == 0? 'Result not available': "<ul class='min-list link-list'>" +
                        result.professors.map(post => `
                    <li>
                    <a class="professor-card" href="${post.url}">
                        <img src="${post.image}" alt="" class="professor-card__image">
                        <span class="professor-card__name">${post.title}</span>
                        </a>
                    </li>`).join('') + '</ul>'}
        
                </div>
                <div class='one-third'>
                    <h2 class="search-overlay__section-title">Events</h2>
                     ${result.events.length == 0? 'Result not available': "<ul class='min-list link-list'>" +
                        result.events.map(post => `
                            <div class="event-summary">
                                <a class="event-summary__date t-center" href="${post.url}">
                                    <span class="event-summary__month">${post.month}</span>
                                    <span class="event-summary__day">${post.date}</span>
                                </a>
                                <div class="event-summary__content">
                                <h5 class="event-summary__title headline headline--tiny"><a href="${post.url}">${post.title}</a></h5>
                                <p>${post.description}<a href="${post.url}" class="nu gray">Learn more</a></p>
                                </div>
                            </div>
                            `).join('') + '</ul>'}

                    <h2 class="search-overlay__section-title">Campus</h2>
                    ${result.campuses.length == 0? 'Result not available': "<ul class='min-list link-list'>" +
                        result.campuses.map(post => `<li><a href=${post.url}'>${post.title}</a></li>`).join('') + '</ul>'}

                </div>
           </div>` 
        })

        this.isSpinnerLoaded = false;
        
    }

    searchFunctionalityJS(){
        document.querySelector('body').insertAdjacentHTML('beforeend',`
            <div class="search-overlay">
                <div class="search-overlay__top">
                    <div class="container">
                    <i class="fa fa-search search-overlay__icon"></i>
                    <input type="text" placeholder="What are you looking for..." class="search-term" id="search-term">
                    <i class="fa fa-window-close search-overlay__icon close-search"></i>
                    </div>
                </div>
                <div class="container">
                    <div class="search-overlay__result ">
                        <div class="spinner-icon"></div>
                    </div>
                </div>
            </div>
            `)
    }

}

export default LiveSearch;
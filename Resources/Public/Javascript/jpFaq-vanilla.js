"use strict";

function ajaxPost(loadUri, contentContainer) {
    var xhr = new XMLHttpRequest();

    return new Promise((resolve, reject) => {
        xhr.onreadystatechange = (e) => {
            if (xhr.readyState !== 4) {
                return;
            }

            if (xhr.status === 200) {
                resolve(xhr.responseText);
            } else {
                reject(console.warn("request_error"));
            }
        };

        xhr.open("POST", loadUri);
        xhr.send();
    });
}

class rateAnswer {
    constructor(rateEl) {
        this.ratingBtn = rateEl;

        this.initialize();
    }

    initialize() {
        this.rate();
    }

    rate() {
        this.ratingBtn.addEventListener("click", function (e) {
            e.preventDefault();
            const jpfaqCommentPageType = "&type=88188";
            const jpfaqQuestionHelpfulText = e.target.closest(
                ".jpfaqQuestionHelpfulText"
            );
            const jpfaqQuestionCommentContainer = e.target.closest(
                ".jpfaqQuestionCommentContainer"
            );
            const loadUri = e.target.getAttribute("href") + jpfaqCommentPageType;
            ajaxPost(loadUri).then((response) => {
                jpfaqQuestionCommentContainer.appendChild(
                    document.createElement("div")
                );
                jpfaqQuestionCommentContainer.className = "jpfaqAddCommentForm";
                jpfaqQuestionCommentContainer.innerHTML = response;
                jpfaqQuestionHelpfulText.classList.add("d-none");
            });
        });
    }
}

class AccordionItem {
    constructor(domNode) {
        this.rootEl = domNode;
        this.buttonEl = this.rootEl.querySelector("button[aria-expanded]");

        const controlsId = this.buttonEl.getAttribute("aria-controls");
        this.contentEl = document.getElementById(controlsId);

        this.rateEl = this.rootEl.querySelectorAll(".jpfaq-rate");

        this.showHideEl = this.rootEl
            .closest(".tx-jpfaq")
            .querySelectorAll(".jpfaq-action");

        this.initialize();
    }

    initialize() {
        // add event listeners
        this.buttonEl.addEventListener("click", this.onButtonClick.bind(this));

        this.rateEl.forEach((elem) => {
            new rateAnswer(elem);
        });

        this.showHideEl.forEach((elem) => {
            elem.addEventListener("click", (e) => {
                console.log(e.target.dataset.action);

                const action = e.target.dataset.action;

                // Todo: not nice to repeat show/collapse again
                if (action == "collapse") {
                    this.buttonEl.setAttribute("aria-expanded", "false");
                    this.buttonEl.classList.add("collapsed");
                    this.contentEl.classList.remove("show");
                }
                if (action == "show") {
                    this.buttonEl.setAttribute("aria-expanded", "true");
                    this.buttonEl.classList.remove("collapsed");
                    this.contentEl.classList.add("show");
                }
            });
        });
    }

    onButtonClick() {
        AccordionItem.toggle(this, !this.open);
    }

    static toggle(instance, open) {
        // don't do anything if the open state doesn't change
        if (open === instance.open) {
            return;
        }

        // update the internal state
        instance.open = open;

        // handle DOM updates
        instance.buttonEl.setAttribute("aria-expanded", open);
        instance.buttonEl.classList.toggle("collapsed", !open);
        instance.contentEl.classList.toggle("show", open);
    }

    // Add public open and close methods for convenience
    show() {
        AccordionItem.toggle(this, true);
    }

    collapse() {
        AccordionItem.toggle(this, false);
    }
}

class ListFilter {
    constructor(searchEl, listEl) {
        // store the search input and list element as properties on this object
        this.input = searchEl.querySelector("input");
        this.list = listEl;

        // add an event listener to the input that calls the filter method when the input value changes
        this.input.addEventListener("input", this.filter.bind(this));

        // call the initialize method to set up any initial state or logic
        this.initialize();
    }

    initialize() {
        // this method is called when the class is instantiated, it is used for setting up initial state or logic

        // Prevent reload page on submit search
        this.input.addEventListener("keypress", (e) => {
            if (e.keyCode == 13) {
                e.preventDefault();
            }
        });
    }

    filter() {
        // get the items to be filtered
        const items = this.list;

        // iterate over each item and check if it matches the input value
        items.forEach((item) => {
            // get the text content of the item
            const text = item.innerHTML;

            /*
             * Todo: showing? hiding? closing? Should be tested and optimized
             */
            if (text.toUpperCase().indexOf(this.input.value.toUpperCase()) > -1) {
                item.classList.remove("d-none");
            } else {
                // if the text content does not contain the input value, add the class that hides the item
                item
                    .querySelector("button[aria-expanded]")
                    .setAttribute("aria-expanded", "false");
                item.querySelector(".collapse").classList.remove("show");
                item.classList.add("d-none");
            }
        });
    }
}

class Accordion {
    constructor(domNode) {
        this.rootEl = domNode;

        this.items = this.rootEl.querySelectorAll(".jpfaq-item");
        this.search = this.rootEl.querySelector(".jpfaq-search");

        this.initialize();
    }

    initialize() {
        this.items.forEach((item) => {
            new AccordionItem(item);
        });
        new ListFilter(this.search, this.items);
    }
}

// init accordions
const accordions = document.querySelectorAll(".tx-jpfaq");
accordions.forEach((elem) => {
    new Accordion(elem);
});

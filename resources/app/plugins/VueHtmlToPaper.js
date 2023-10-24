function addStyles(win, styles) {
    styles.forEach((style) => {
        let link = win.document.createElement("link");
        link.setAttribute("rel", "stylesheet");
        link.setAttribute("type", "text/css");
        link.setAttribute("media", "print");
        link.setAttribute("href", style);
        win.document.getElementsByTagName("head")[0].appendChild(link);
    });
}

const VueHtmlToPaper = {
    install(app, options = {}) {
        app.config.globalProperties.$htmlToPaper = (
            el,
            localOptions,
            cb = () => true
        ) => {
            let defaultName = "_blank",
                defaultSpecs = ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
                defaultReplace = true,
                defaultStyles = [],
                defaultHtml = false,
                defaultData = '';

            let {
                name = defaultName,
                specs = defaultSpecs,
                replace = defaultReplace,
                styles = defaultStyles,
                html = defaultHtml,
                data = defaultData,
            } = options;

            // If has localOptions
            // TODO: improve logic
            if (!!localOptions) {
                if (localOptions.name) name = localOptions.name;
                if (localOptions.specs) specs = localOptions.specs;
                if (localOptions.replace) replace = localOptions.replace;
                if (localOptions.styles) styles = localOptions.styles;
                if (localOptions.html) html = localOptions.html;
                if (localOptions.data) data = localOptions.data;
            }

            specs = !!specs.length ? specs.join(",") : "";

            if(html){
                data = el;
            }else{
                const element = window.document.getElementById(el);
                if (!element) {
                    alert(`Element to print #${el} not found!`);
                    return;
                }
                data = element.innerHTML;
            }

            /* const url = "";
            const win = window.open(url, name, specs, replace); */
            // console.log(data);

            var ifprint = document.createElement("iframe");
            ifprint.style.position = "fixed";
            ifprint.style.right = "0";
            ifprint.style.bottom = "0";
            ifprint.style.width = "0";
            ifprint.style.height = "0";
            ifprint.style.border = "0";
            document.body.appendChild(ifprint);

            const win = ifprint.contentWindow;

            win.document.write(`<html>
                                    <head>
                                    <title>${window.document.title}</title>
                                    </head>
                                    <body>
                                    ${data}
                                    </body>
                                </html>
                                `);

            addStyles(win, styles);

            setTimeout(() => {
                win.document.close();
                win.focus();
                win.print();
                win.close();
                cb();
            }, 2000);

            return true;
        };
    }
};

export default VueHtmlToPaper;
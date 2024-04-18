
    let url =  'https://www.avito.ru/';
    async function scraper(browser, category, city){
        console.log("Поиск в городе:"+city);
        console.log("Наименование товара:"+category);
        let page = await browser.newPage();
        await page.setDefaultNavigationTimeout(5000000);
        console.log(`Navigating to ${url}...`);
        // Navigate to the selected category
        await page.goto(url + '/' + city + '/' + category);

        async function scrapeCurrentPage(page){
            const divCount = await page.evaluate(() => {
                const element = document.querySelector(".index-center-_TsYY.index-center_withTitle-_S7ge.index-centerWide-_7ZZ_.index-center_marginTop_1-ewXHO > div.index-inner-dqBR5.index-innerCatalog-ujLwf > div.index-content-_KxNP > div.js-pages.pagination-pagination-_FSNE > nav > ul > li.styles-module-listItem-_La42.styles-module-listItem_last-GI_us.styles-module-listItem_notFirst-LGEQU > a");
                return element ? element.getAttribute('data-value') : null;
            });
            const promises = [];
            console.log("Найдено страниц:"+ divCount);
            try {
                for (let i = 1; i<=divCount;i++) {
                    const newPage = await browser.newPage();
                    await newPage.goto('https://www.avito.ru/' + city + '/' + category + "?cd=1&p=" + i);
                    await page.waitForSelector('.js-promo-sticky-container');

                    promises.push(parserBaseProductInfo(newPage));
                    await newPage.waitForTimeout(7000);
                    await newPage.close();
                }
            } catch (error) {
                console.error('Произошла ошибка:', error);
            }
            
            return Promise.all(promises);
        }
        let data = await scrapeCurrentPage(page);
        await page.close();
        return data.flat();
    }


async function parserBaseProductInfo(page) {
    return await page.$$eval("div[class^='iva-item-root-']", divs => {
        return divs.map(el => {
            const urlElement = el.querySelector("a");
            const titleElement = el.querySelector("a");
            const priceElement = el.querySelector(".iva-item-priceStep-uq2CQ");
            const descriptionElement = el.querySelector(".iva-item-descriptionStep-C0ty1");

            // Проверяем наличие элементов перед получением их содержимого
            const link = urlElement ? urlElement.href : '';
            const title = titleElement ? titleElement.title : '';
            const price = priceElement ? priceElement.textContent : '';
            const description = descriptionElement ? descriptionElement.textContent : '';
            return { link, title, price, description };
        });
    });
}
module.exports = (browserInstance, productName, city) => scraper(browserInstance, productName, city);

const pageScraper = require('./pageScraper');

async function scrapeAll(browserInstance, productName, cityName){
        let scrapedData = {};
        let browser = await browserInstance;
        scrapedData[productName] = await pageScraper(browser, await productName, await cityName);
        return scrapedData;
}

module.exports = (browserInstance, productName, city) => scrapeAll(browserInstance, productName, city)

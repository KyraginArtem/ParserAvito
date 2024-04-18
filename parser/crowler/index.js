const express = require('express');
const bodyParser = require('body-parser');

//запускаем баузер
const browserObject = require("./browser");

//Go Controller
const scraperController = require("./pageController");

const app = express();
const port = 3000;
app.use(bodyParser.json());
app.post('/crowler', async (req, res) => {
    let productName = req.body.productName;
    let city = req.body.city;
//Start the browser and create a browser instance
    let browserInstance = browserObject.startBrowser();

//Pass the browser instance to the scraper controller
    let resultScraper = await scraperController(browserInstance, productName, city);

    console.log('Send response parser date.')
    res.status(200).json(resultScraper);
});

//Слушает порт, ждет запроса
app.listen(port, () => {
    console.log(`Server is running at http://localhost:${port}`);
});

//  user related routes will be handled here
const express = require("express");
const router = express.Router();

const {
    recordDisplayPage,
    addRecordPage,
    addRecord,
    recordEditPage,
    editRecord,
    imageUploadPage,
    uploadImage,
    recordDeletePage,
    profilepage
} = require("../controllers/courseController");

const usercontroller = require("../controllers/userController");

router.get("/profile", usercontroller.showProfile);

router.get("/takesurvey", usercontroller.takesurvey);
router.post("/takesurvey/search", usercontroller.searchsurvey);

router.get("/takesurvey/sortbyname", usercontroller.sortbyname);
router.get("/takesurvey/sortbydatedesc", usercontroller.sortbydatedesc);
router.get("/takesurvey/sortbydateasc", usercontroller.sortbydateasc);

router.get("/takesurvey/id", usercontroller.showsurvey);
router.get("/first", usercontroller.showlandingpage);

router.get("/profile/add", usercontroller.addprofile);
router.get('/pages/addImage', imageUploadPage);
router.post('/pages/addImage', uploadImage);

module.exports = router;
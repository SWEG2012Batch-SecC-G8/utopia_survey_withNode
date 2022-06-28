const router = require("express").Router();
const { body } = require("express-validator");

/* pages route */
const {
    homePage,
    register,
    registerPage,
    login,
    loginPage,
    forgotPassword,
    sendResetPassLink,
    resetPasswordPage,
    resetPassword,
    create_survey,
    insert_survey,
    contactUs
} = require("../controllers/authController");


const { isLoggedin, isNotLoggedin } = require('../lib/check_authentication');
const validator = require('../lib/validation_rules');

router.get('/', isLoggedin, homePage);
router.post('/', isLoggedin, homePage);

router.get("/pages/login", isNotLoggedin, loginPage);
router.post("/pages/login", isNotLoggedin, validator.validationRules[0], login);

router.get("/pages/signup", isNotLoggedin, registerPage);
router.post("/pages/signup", isNotLoggedin, validator.validationRules[1], register);

router.get('/user/logout',
    (req, res, next) => {
        req.session.destroy(
            (err) => {
                next(err);
            }
        );
        res.redirect('/pages/login');
    }
);

router.get("/pages/passReset_Request", isNotLoggedin, forgotPassword);
router.post("/pages/passReset_Request", isNotLoggedin, sendResetPassLink);

router.get("/reset-password", isNotLoggedin, resetPasswordPage);
router.post("/reset-password", isNotLoggedin, validator.validationRules[3], resetPassword);

router.get('/pages/create_survey', isLoggedin, create_survey);
router.post("/pages/create_survey", isLoggedin, insert_survey);

router.get('/pages/contactUs', contactUs);
// router.post('/pages/contactUs', saveFile);


module.exports = router;
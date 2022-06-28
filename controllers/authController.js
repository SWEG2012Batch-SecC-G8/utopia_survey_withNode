var randtoken = require('rand-token');
var nodemailer = require('nodemailer');

const { validationResult } = require("express-validator");
const encrypt = require('../lib/hashing');
const sendMail = require('../lib/sendEmail');

const dbConn = require("../config/db_Connection")

// Home Page
exports.homePage = (req, res, next) => {
    // var query1;
    // if (req.method == 'GET') {
    //     if (req.session.level == 1)
    //         query1 = 'SELECT * FROM `courses`';
    //     else
    //         query1 = `SELECT * FROM courses as CO LEFT JOIN customer as US ` +
    //         `ON CO.user_id = US.id WHERE US.id = "${req.session.userID}"`;
    // } else if (req.method == 'POST') {
    //     const { body } = req;
    //     //fulltext search 
    //     if (req.session.level == 1) {
    //         query1 = `SELECT * FROM courses WHERE MATCH (code, title, description)` +
    //             ` AGAINST ("${body.search_Key}" IN NATURAL LANGUAGE MODE)`;
    //     } else {
    //         query1 = `SELECT * FROM courses as CO LEFT JOIN customer as US ON CO.user_id = US.id` +
    //             ` WHERE US.id = "${req.session.userID}"` +
    //             ` AND MATCH (code, title, description)` +
    //             ` AGAINST ("${body.search_Key}" IN NATURAL LANGUAGE MODE)`;
    //     }

    //     //Alternative: search multiple columns with "concat & like" operators 
    //     /*
    //      * `SELECT * FROM courses WHERE concat (code, title, description)` +
    //      *		` like "%${body.search_Key}%"`;		
    //      */
    // }
    // dbConn.query(query1, async(error, result) => {

    //     if (error) {
    //         console.log(error);
    //         throw error;
    //     }
    //     res.render('home', { data: result, title: 'Homepage' });
    // });
    res.render('./home', { title: 'Homepage' });
}

// Register Page
exports.registerPage = (req, res, next) => {
    res.render("pages/register");
};

// User Registration
exports.register = async(req, res, next) => {
    const errors = validationResult(req);
    const { body } = req;

    if (!errors.isEmpty()) {
        return res.render('pages/register', { error: errors.array()[0].msg });
    }


    try {
        var query2 = "SELECT * FROM `customer` WHERE `email`=?";
        console.log(body.email)
        dbConn.query(query2, [body.email], async(error, row) => {
            if (error) {
                console.log(error)
                throw error
            }

            if (row.length >= 1) {
                return res.render('pages/register', { error: 'This email already in use.' });
            }

            //const hashPass = await bcrypt.hash(body._password, 12);
            const hashPass = await encrypt.encryptPassword(body.password);
            var query3 = "INSERT INTO  `customer` ( `email`, `firstname`, `lastname`, `password`, `phonenumber`, `job`, `gender`, `birthdate`) VALUES(?,?,?,?,?,?,?,?)";
            dbConn.query(query3, [body.email, body.fname, body.lname, hashPass, body.phonenumber, body.job, body.gender, body.birthdate],
                (error, rows) => {
                    if (error) {
                        console.log(error);
                        throw error;
                    }

                    if (rows.affectedRows !== 1) {
                        return res.render('pages/register', { error: 'Your registration has failed.' });
                    }

                    res.render("pages/register", { msg: 'You have successfully registered. You can Login now!' });
                });
        });
    } catch (e) {
        next(e);
    }
};

// Login Page
exports.loginPage = (req, res, next) => {
    res.render("pages/login");
};

// Login User
exports.login = (req, res, next) => {

    const errors = validationResult(req);
    const { body } = req;

    if (!errors.isEmpty()) {
        return res.render('pages/login', {
            error: errors.array()[0].msg
        });
    }

    try {
        var query4 = 'SELECT * FROM `customer` WHERE `email`=?'
        dbConn.query(query4, [body.email], async function(error, row) {
            if (error)
                throw error;
            else {
                if (row.length != 1) {
                    return res.render('pages/login', {
                        error: 'Invalid email address or password.'
                    });
                }

                //const checkPass = await bcrypt.compare(body.password, row[0].password);
                const checkPass = await encrypt.matchPassword(body.password, row[0].password);

                if (checkPass === true) {
                    req.session.userID = row[0].firstname;
                    req.session.email = row[0].email;
                    req.session.level = row[0].level;
                    return res.render('home');
                }

                res.render('/login', { error: 'Invalid email address or password.' });

            }
        });
    } catch (e) {
        next(e);
    }
}


// Password reset link request Page
exports.forgotPassword = (req, res, next) => {
    res.render("pages/passReset_Request");
};

/* send reset password link in email */
exports.sendResetPassLink = (req, res, next) => {

    const { body } = req;
    const email = body.email;

    var query2 = 'SELECT * FROM cutomer WHERE email ="' + email + '"';
    dbConn.query(query2, function(err, result) {
        if (err)
            throw err;

        if (result.length > 0) {
            const token = randtoken.generate(20);
            const sent = sendMail.sendingMail(email, token);

            if (sent != '0') {
                var data = { token: token }
                var query3 = 'UPDATE customer SET ? WHERE email ="' + email + '"';
                dbConn.query(query3, data, function(err, result) {
                    if (err)
                        throw err
                })

                res.render('pages/passReset_Request', { msg: 'The reset password link has been sent to your email address' });
            } else {
                res.render('pages/passReset_Request', { error: 'Something goes to wrong. Please try again' })
            }
        } else {
            console.log('2');
            res.render('pages/passReset_Request', { error: 'The Email is not registered with us' })
        }
    });
}

// Password reset Page
exports.resetPasswordPage = (req, res, next) => {
    res.render("pages/reset_password", { token: req.query.token });
}

/* update password to database */
exports.resetPassword = (req, res, next) => {

    const errors = validationResult(req);
    const { body } = req;

    if (!errors.isEmpty()) {
        return res.render('pages/reset_password', { token: token, error: errors.array()[0].msg });
    }

    var token = body.token;
    var query5 = 'SELECT * FROM customer WHERE token ="' + token + '"';
    dbConn.query(query5, async(err, result) => {
        if (err)
            throw err;

        if (result.length > 0) {
            const hashPass = await encrypt.encryptPassword(body.password);
            var query5 = 'UPDATE customer SET password = ? WHERE email ="' + result[0].email + '"';
            dbConn.query(query5, hashPass, function(err, result) {
                if (err)
                    throw err
            });

            res.render("pages/reset_password", { token: 0, msg: 'Your password has been updated successfully' });
        } else {
            console.log('2');
            res.render("pages/reset_password", { token: token, error: 'Invalid link; please try again' });
        }
    });
}




exports.create_survey = (req, res, next) => {
    res.render("pages/create_survey");
};

exports.insert_survey = async(req, res, next) => {

    const { body } = req;

    try {


        var query3 = "INSERT INTO  `created_survey` ( `survey_title`,`category`, `created_date`, `dead_line`, `description`, `participant_limit`, `prefered_gender`, `survey_creater`, `target_age`, `target_job`, `target_place`) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
        dbConn.query(query3, [body.survey_title, body.category, body.created_date, body.dead_line, body.description, body.participant_limit, body.gender, req.session.email, body.targetage, body.job, body.target_place],
            (error, rows) => {
                if (error) {
                    console.log(error);
                    throw error;
                }

                if (rows.affectedRows !== 1) {
                    return res.render('pages/create_survey', { error: 'Your registration has failed.' });
                }
                //next();
                res.render("pages/studio");
            });

    } catch (e) {
        //next(e);
    }

};

exports.contactUs = (req, res, next) => {
    res.render("pages/contactUs");
};
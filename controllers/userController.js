const dbConn = require("../config/db_Connection");
const validator = require("../lib/validation_rules");
const showProfile = (req, res) => {
    var email = req.session.email;


    var query1;
    query1 = "SELECT * FROM customer where email='" +
        email + "'";

    dbConn.query(query1, (error, result) => {
        if (error) throw error;
        console.log(result);
        console.log(result[0].email);

        res.render("pro", {
            data: result,
        });
    });
};

const addprofile = (req, res) => {
    res.render("pages/addImage");
};

const takesurvey = (req, res) => {



    var query1;
    query1 = "SELECT * FROM created_survey";

    dbConn.query(query1, (error, result) => {
        if (error) throw error;
        console.log(result);


        res.render("pages/takesurvey", {
            data: result,
        });
    });

};


const searchsurvey = (req, res) => {
    console.log("we got to search ");

    const { body } = req;
    var title = body.search;
    console.log(title);
    var query1;

    query1 = "SELECT * FROM created_survey where survey_title ='" +
        title + "'"



    dbConn.query(query1, (error, result) => {
        if (error) throw error;
        console.log(result);


        res.render("pages/takesurvey", {
            data: result,
        });
    });

};



const sortbyname = (req, res) => {
    console.log("we got to sort by name ");


    var query1;

    query1 = "SELECT * FROM created_survey Order by survey_title desc";



    dbConn.query(query1, (error, result) => {
        if (error) throw error;
        console.log(result);


        res.render("pages/takesurvey", {
            data: result,
        });
    });

};



const sortbydatedesc = (req, res) => {
    console.log("we got to sort by name ");


    var query1;

    query1 = "SELECT * FROM created_survey Order by created_date desc";



    dbConn.query(query1, (error, result) => {
        if (error) throw error;
        console.log(result);


        res.render("pages/takesurvey", {
            data: result,
        });
    });

};

const sortbydateasc = (req, res) => {
    console.log("we got to sort by name ");


    var query1;

    query1 = "SELECT * FROM created_survey Order by created_date asc";



    dbConn.query(query1, (error, result) => {
        if (error) throw error;
        console.log(result);


        res.render("pages/takesurvey", {
            data: result,
        });
    });

};


const showsurvey = (req, res) => {
    res.render("pages/takesurveydetail");
};

const showlandingpage = (req, res) => {
    res.render("pages/first");
};

// const createsurvey = (req, res) => {
//     var query1;
//     query1 = "insert into  employee values (x,y,z)";

//     dbConn.query(query1, (error, result) => {
//         if (error) throw error;
//         res.render("pro", {
//             data: result,
//         });
//     });
//     //  after inserting the newly created survey  we need to fetch it again and pass it to take sruvey page
//     var query1;
//     query1 = "SELECT * FROM employee where empId=1";

//     dbConn.query(query1, (error, result) => {
//         if (error) throw error;
//         console.log(result);
//         console.log(result[0].email);

//         res.render("pro", {
//             data: result,
//         });
//     });

//  WE PASS THE DATA TO TAKESURVEY PAGE

// res.render("pages/takesurvey");
// };


module.exports = {
    showProfile,
    showlandingpage,
    showsurvey,
    takesurvey,
    searchsurvey,
    sortbyname,
    sortbydatedesc,
    sortbydateasc,
    addprofile,
};
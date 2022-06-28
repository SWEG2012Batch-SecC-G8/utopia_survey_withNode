var nodemailer = require('nodemailer');

//send email
exports.sendingMail = (email, token) => {

    var email = email;
    var token = token;

    var mail = nodemailer.createTransport({
        service: 'gmail',
        auth: {
            user: 'maharitesfaye93@gmail.com', // Your email id
            pass: '**Appdev#024680' // Your password
        }
    });

    var mailOptions = {
        from: 'maharitesfaye93@gmail.com',
        to: email,
        subject: 'Verify your email',
        html: '<p>You are required to verify your email, kindly use this' +
            '<a href="http://localhost:5000/reset-password?token=' + token + '">' +
            ' link</a> verify </p>'
    };

    mail.sendMail(mailOptions, function(error, info) {
        if (error)
            console.log('verify link sent')
        else
            console.log('Error: link not sent')
    });

}
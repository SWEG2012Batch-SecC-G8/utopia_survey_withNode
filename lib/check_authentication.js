module.exports = {
    isLoggedin(req, res, next) {
        if (req.session.userID) {
            return next();
        }
        return res.redirect('/pages/login');
    },

    isNotLoggedin(req, res, next) {
        if (!req.session.userID) {
            return next();
        }
        return res.redirect('/');
    }

}
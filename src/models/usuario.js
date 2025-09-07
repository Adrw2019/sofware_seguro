const mongoose = require('mongoose');

const usuarioSchema = new mongoose.Schema({
    username: {
        type: String,
        required: true,
        unique: true
    },
    password: {
        type: String,
        required: true
    },
    email: {
        type: String,
        required: true,
        unique: true
    }
});

usuarioSchema.statics.registerUser = async function(username, password, email) {
    const user = new this({ username, password, email });
    return await user.save();
};

usuarioSchema.statics.findUserByUsername = async function(username) {
    return await this.findOne({ username });
};

usuarioSchema.statics.findUserByEmail = async function(email) {
    return await this.findOne({ email });
};

module.exports = mongoose.model('Usuario', usuarioSchema);
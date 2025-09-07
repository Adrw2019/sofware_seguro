const mongoose = require('mongoose');

const inventarioSchema = new mongoose.Schema({
    itemName: {
        type: String,
        required: true
    },
    quantity: {
        type: Number,
        required: true,
        min: 0
    },
    description: {
        type: String,
        required: false
    }
});

const Inventario = mongoose.model('Inventario', inventarioSchema);

module.exports = Inventario;
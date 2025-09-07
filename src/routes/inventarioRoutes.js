const express = require('express');
const router = express.Router();
const inventarioController = require('../controllers/inventarioController');

// Route to get all inventory items
router.get('/items', inventarioController.getItems);

// Route to add a new inventory item
router.post('/items', inventarioController.addItem);

// Route to update an existing inventory item
router.put('/items/:id', inventarioController.updateItem);

// Route to delete an inventory item
router.delete('/items/:id', inventarioController.deleteItem);

module.exports = router;
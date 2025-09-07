const Inventario = require('../models/inventario');

// Function to add a new inventory item
exports.addItem = async (req, res) => {
    try {
        const { itemName, quantity, description } = req.body;
        const newItem = new Inventario({ itemName, quantity, description });
        await newItem.save();
        res.status(201).json({ message: 'Item added successfully', item: newItem });
    } catch (error) {
        res.status(500).json({ message: 'Error adding item', error });
    }
};

// Function to update an existing inventory item
exports.updateItem = async (req, res) => {
    try {
        const { id } = req.params;
        const { itemName, quantity, description } = req.body;
        const updatedItem = await Inventario.findByIdAndUpdate(id, { itemName, quantity, description }, { new: true });
        if (!updatedItem) {
            return res.status(404).json({ message: 'Item not found' });
        }
        res.json({ message: 'Item updated successfully', item: updatedItem });
    } catch (error) {
        res.status(500).json({ message: 'Error updating item', error });
    }
};

// Function to delete an inventory item
exports.deleteItem = async (req, res) => {
    try {
        const { id } = req.params;
        const deletedItem = await Inventario.findByIdAndDelete(id);
        if (!deletedItem) {
            return res.status(404).json({ message: 'Item not found' });
        }
        res.json({ message: 'Item deleted successfully' });
    } catch (error) {
        res.status(500).json({ message: 'Error deleting item', error });
    }
};

// Function to get all inventory items
exports.getItems = async (req, res) => {
    try {
        const items = await Inventario.find();
        res.json(items);
    } catch (error) {
        res.status(500).json({ message: 'Error retrieving items', error });
    }
};
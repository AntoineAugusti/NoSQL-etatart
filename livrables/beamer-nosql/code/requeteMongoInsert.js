db.inventory.insert(
   {
     item: "ABC1",
     details: {
        model: "14Q3",
        manufacturer: "XYZ Company"
     },
     stock: [
     	{ size: "S", qty: 25 },
     	{ size: "M", qty: 50 }
     ],
     category: "clothing"
   }
)

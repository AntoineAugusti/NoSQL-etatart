db.inventory.update(
    { item: "MNO2" },
    {
      $set: {
        category: "apparel",
        details.model: "14Q2"
      },
      $currentDate: { lastModified: true }
    }
)
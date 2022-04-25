class CreateProduits < ActiveRecord::Migration[7.0]
  def change
    create_table :produits do |t|
      t.string :name
      t.integer :price
      t.integer :quantity
      t.integer :stock
      t.references :category, null: false, foreign_key: true

      t.timestamps
    end
  end
end

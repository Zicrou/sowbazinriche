class Produit < ApplicationRecord
  belongs_to :category

  validates_presence_of :name, :price, :quantity, :category_id, message: "can't be blank!"
end

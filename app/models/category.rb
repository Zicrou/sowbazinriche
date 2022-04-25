class Category < ApplicationRecord
    has_many :produits
    
    validates_presence_of :name, on: [:create, :update], message: "Veuillez saisir un nom de produit!"
    #validates_presence_of :attribute, on: :create, message: "can't be blank"
end

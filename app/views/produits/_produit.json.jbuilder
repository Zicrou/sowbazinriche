json.extract! produit, :id, :name, :price, :quantity, :stock, :category_id, :created_at, :updated_at
json.url produit_url(produit, format: :json)

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artisanat Marocain - Boutique</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #6e3b23;
            margin-bottom: 30px;
        }
        .products-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .product-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-image {
            height: 200px;
            background-color: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 14px;
        }
        .product-info {
            padding: 15px;
        }
        .product-title {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 16px;
        }
        .product-price {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .current-price {
            font-size: 18px;
            color: #6e3b23;
            font-weight: bold;
        }
        .old-price {
            text-decoration: line-through;
            color: #999;
            margin-left: 10px;
            font-size: 14px;
        }
        .product-meta {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        .badge {
            background-color: #6e3b23;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            display: inline-block;
            margin-bottom: 10px;
        }
        .rating {
            color: #ffc107;
        }
        .order-btn {
            background-color: #6e3b23;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .order-btn:hover {
            background-color: #8a4b2f;
        }
        .order-summary {
            margin-top: 40px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .order-summary h2 {
            color: #6e3b23;
            margin-top: 0;
        }
        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: none;
            font-family: inherit;
        }
    </style>
</head>
<body>
    <h1>Artisanat Marocain - Nos Produits</h1>
    
    <div class="products-container">
        <!-- Les produits seront insérés ici par JavaScript -->
    </div>
    
    <div class="order-summary">
        <h2>Votre Commande</h2>
        <textarea id="order-text" readonly placeholder="Vos commandes apparaîtront ici..."></textarea>
    </div>

    <script>
        const products = [
            {
                id: 1,
                title: "Vase en Zellige 'Étoile de Fès'",
                price: 1450,
                oldPrice: null,
                rating: 4.5,
                category: "zellige & céramique",
                region: "fes",
                image: "vv.jpg",
                badge: "Nouveauté",
                description: "Magnifique vase en zellige traditionnel de Fès, fabriqué à la main par nos maîtres artisans. Chaque pièce est unique avec ses motifs géométriques complexes et ses couleurs vibrantes."
            },
            {
                id: 2,
                title: "Tapis Berbère 'Lignes du désert'",
                price: 3200,
                oldPrice: 3800,
                rating: 4.0,
                category: "tapis berbères",
                region: "sahara",
                image: "bbb.jpg",
                badge: null,
                description: "Tapis berbère authentique tissé à la main par les femmes du Sahara. Laine naturelle teintée avec des pigments végétaux. Dimensions : 200x140 cm."
            },
            {
                id: 3,
                title: "Plateau Marqueterie 'Arabesque'",
                price: 2150,
                oldPrice: null,
                rating: 5.0,
                category: "marqueterie",
                region: "essaouira",
                image: "pp.jpg",
                badge: "Édition Limitée",
                description: "Plateau en marqueterie de thuya réalisé par des artisans d'Essaouira. Motifs arabesques traditionnels avec incrustations de nacre."
            },
            {
                id: 4,
                title: "Luminaire en Cuivre 'Lune du Sud'",
                price: 1890,
                oldPrice: null,
                rating: 4.0,
                category: "luminaires",
                region: "marrakech",
                image: "luu.jpg",
                badge: null,
                description: "Luminaire artisanal en cuivre martelé, inspiré des lanternes traditionnelles des riads marocains. Diamètre : 45 cm."
            },
            {
                id: 5,
                title: "Collier Berbère en Argent",
                price: 850,
                oldPrice: null,
                rating: 4.0,
                category: "bijoux",
                region: "atlas",
                image: "co.jpg",
                badge: null,
                description: "Collier berbère en argent 925, orné de motifs traditionnels et de pierres semi-précieuses. Longueur : 50 cm."
            },
            {
                id: 6,
                title: "Set de 2 Coussins Brodés",
                price: 690,
                oldPrice: null,
                rating: 3.0,
                category: "textiles",
                region: "atlas",
                image: "ci.jpg",
                badge: null,
                description: "Set de deux coussins en coton brodé à la main par des artisanes de l'Atlas. Dimensions : 40x40 cm."
            },
            {
                id: 7,
                title: "Pot en Céramique Bleue de Fès",
                price: 1250,
                oldPrice: null,
                rating: 4.5,
                category: "zellige & céramique",
                region: "fes",
                image: "poti.jpg",
                badge: "Meilleure Vente",
                description: "Pot en céramique émaillée bleue typique de Fès, décoré à la main avec des motifs traditionnels. Hauteur : 35 cm."
            },
            {
                id: 8,
                title: "Tasse en Zellige de Fès",
                price: 320,
                oldPrice: null,
                rating: 4.2,
                category: "zellige & céramique",
                region: "fes",
                image: "tasse.jpg",
                badge: null,
                description: "Tasse artisanale décorée avec des carreaux de zellige typiques de Fès. Idéale pour le café ou le thé marocain."
            },
            {
                id: 9,
                title: "Tapis Taznakht en Laine Naturelle",
                price: 3400,
                oldPrice: 3900,
                rating: 4.4,
                category: "tapis berbères",
                region: "sud marocain",
                image: "taznakht.jpg",
                badge: "Édition Limitée",
                description: "Tapis traditionnel Taznakht tissé à la main avec laine naturelle. Motifs berbères complexes et couleurs chaleureuses. 220x150 cm."
            },
            {
                id: 10,
                title: "Coffret en Marqueterie de Thuya",
                price: 990,
                oldPrice: null,
                rating: 4.7,
                category: "marqueterie",
                region: "essaouira",
                image: "coffret.jpg",
                badge: null,
                description: "Coffret raffiné en bois de thuya avec incrustations géométriques en citronnier et nacre. Parfait pour bijoux ou souvenirs."
            },
            {
                id: 11,
                title: "Suspension en Laiton 'Éclat du Désert'",
                price: 2050,
                oldPrice: 2400,
                rating: 4.5,
                category: "luminaires",
                region: "marrakech",
                image: "suspension.jpg",
                badge: "Nouveauté",
                description: "Suspension artisanale en laiton ciselé, inspirée des formes lunaires marocaines. Diamètre : 50 cm. Fait main à Marrakech."
            },
            {
                id: 12,
                title: "Bracelet Berbère en Argent Gravé",
                price: 670,
                oldPrice: null,
                rating: 4.3,
                category: "bijoux",
                region: "atlas",
                image: "bracelet.jpg",
                badge: null,
                description: "Bracelet ouvert en argent massif 925 gravé de motifs berbères ancestraux. Artisanat de l'Atlas central."
            }
        ];

        // Afficher les produits
        const productsContainer = document.querySelector('.products-container');
        const orderTextarea = document.getElementById('order-text');
        let orders = [];

        products.forEach(product => {
            const productCard = document.createElement('div');
            productCard.className = 'product-card';
            
            productCard.innerHTML = `
                <div class="product-image">${product.image}</div>
                <div class="product-info">
                    ${product.badge ? `<span class="badge">${product.badge}</span>` : ''}
                    <div class="product-title">${product.title}</div>
                    <div class="product-price">
                        <span class="current-price">${product.price} DH</span>
                        ${product.oldPrice ? `<span class="old-price">${product.oldPrice} DH</span>` : ''}
                    </div>
                    <div class="product-meta">
                        <span>${product.category}</span>
                        <span class="rating">${'★'.repeat(Math.floor(product.rating))}${'☆'.repeat(5 - Math.floor(product.rating))}</span>
                    </div>
                    <div class="product-meta">
                        <span>${product.region}</span>
                    </div>
                    <button class="order-btn" data-id="${product.id}">Commander</button>
                </div>
            `;
            
            productsContainer.appendChild(productCard);
        });

        // Gérer les commandes
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('order-btn')) {
                const productId = parseInt(e.target.getAttribute('data-id'));
                const product = products.find(p => p.id === productId);
                
                if (product) {
                    orders.push(product);
                    updateOrderSummary();
                }
            }
        });

        function updateOrderSummary() {
            if (orders.length === 0) {
                orderTextarea.value = "Aucun produit commandé pour le moment.";
                return;
            }
            
            let summary = "Votre commande :\n\n";
            let total = 0;
            
            orders.forEach((product, index) => {
                summary += `${index + 1}. ${product.title} - ${product.price} DH\n`;
                total += product.price;
            });
            
            summary += `\nTotal : ${total} DH`;
            orderTextarea.value = summary;
        }
    </script>
</body>
</html>
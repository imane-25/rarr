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


const productsContainer = document.getElementById('products-container');
const orderSummary = document.getElementById('order-summary');

products.forEach(product => {
    const productDiv = document.createElement('div');
    productDiv.className = 'product';
    
    productDiv.innerHTML = `
        <h3>${product.title}</h3>
        <p>Prix: ${product.price} MAD</p>
        <p>${product.description}</p>
        <button onclick="showQuantityForm(${product.id}, '${product.title}', ${product.price})">Commander</button>
    `;
    
    productsContainer.appendChild(productDiv);
});

function showQuantityForm(productId, productName, productPrice) {
    const quantity = prompt(`Entrez la quantité pour ${productName}:`);
    if (quantity && !isNaN(quantity) && quantity > 0) {
        const orderDetails = `Produit: ${productName}, Prix: ${productPrice} MAD, Quantité: ${quantity}\n`;
        orderSummary.value += orderDetails;
        alert('Commande ajoutée avec succès!');
    } else {
        alert('Veuillez entrer une quantité valide.');
    }
}

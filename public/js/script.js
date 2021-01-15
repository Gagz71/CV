var canvas = document.getElementById( 'canvas' ),
    ctx = canvas.getContext( '2d' ),
    canvas2 = document.getElementById( 'canvas2' ),
    ctx2 = canvas2.getContext( '2d' ),
    // full screen dimensions
    cw = window.innerWidth,
    ch = window.innerHeight,
    charArr = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'],
    maxCharCount = 100,
    fallingCharArr = [],
    fontSize = 10,
    maxColums = cw/(fontSize);
canvas.width = canvas2.width = cw;
canvas.height = canvas2.height = ch;


function randomInt( min, max ) {
    return Math.floor(Math.random() * ( max - min ) + min);
}

function randomFloat( min, max ) {
    return Math.random() * ( max - min ) + min;
}

function Point(x,y)
{
    this.x = x;
    this.y = y;
}

Point.prototype.draw = function(ctx){

    this.value = charArr[randomInt(0,charArr.length-1)].toUpperCase();
    this.speed = randomFloat(1,5);


    ctx2.fillStyle = "rgba(255,255,255,0.8)";
    ctx2.font = fontSize+"px san-serif";
    ctx2.fillText(this.value,this.x,this.y);

    ctx.fillStyle = "#0F0";
    ctx.font = fontSize+"px san-serif";
    ctx.fillText(this.value,this.x,this.y);



    this.y += this.speed;
    if(this.y > ch)
    {
        this.y = randomFloat(-100,0);
        this.speed = randomFloat(2,5);
    }
}

for(var i = 0; i < maxColums ; i++) {
    fallingCharArr.push(new Point(i*fontSize,randomFloat(-500,0)));
}


var update = function()
{

    ctx.fillStyle = "rgba(0,0,0,0.05)";
    ctx.fillRect(0,0,cw,ch);

    ctx2.clearRect(0,0,cw,ch);

    var i = fallingCharArr.length;

    while (i--) {
        fallingCharArr[i].draw(ctx);
        var v = fallingCharArr[i];
    }

    requestAnimationFrame(update);
}

update();


//Animation gallerie portfolio
let images = document.querySelectorAll('.min-img');

//On parcours le tableau contenant toutes les images pour appliquer un écouteur d'évènement sur chacune d'entre elle
images.forEach(function(img){
    img.addEventListener('click', function(){

        //on appel la fonction servant à afficher l'image dont le nom est stocké dans l'attribut "data-image" de la vignette qui a été cliquée (this)
        displayImage(this.dataset.image);
    });
});

//Création d'une fonction qui affiche une image dans un overlay avec une croix de fermeture
function displayImage(imageName){

    //Création d'une <div class="overlay"> insérer au body
    let overlay = document.createElement('div');
    overlay.classList.add('overlay-2');
    document.querySelector('body').prepend(overlay);

    //Création de l'image
    let image = document.createElement('img');
    image.src = "img/" + imageName;
    overlay.append(image); //Insertion de l'image ds l'overlay

    //Création de la croix pour fermeture <div class="close">
    let closeButton = document.createElement('div');
    closeButton.classList.add('close');
    closeButton.textContent = "X";
    overlay.append(closeButton); //Insertion croix ds l'overlay

    //Application d'un écouteur dévènement sur la croix
    closeButton.addEventListener('click', function(){
        removeImage(); //appel de la fonction permettant de supprimer l'overlay
    });
}

//Création d'une fonction qui supprimera l'overlay
function removeImage(){

    //Raccourci vers l'overlay
    let overlay = document.querySelector('.overlay-2'); //une variable d'une fonction n'existe que dans la fonction donc on peut créer autant de variable overlay dans autant de fonctions qu'on veut.

    //Suppression de l'overlay et de son contenu
    overlay.parentElement.removeChild(overlay);

};




/*Animations footer*/
class TextScramble {
    constructor(el) {
        this.el = el;
        this.chars = '!<>-_\\/[]{}—=+*^?#________';
        this.update = this.update.bind(this);
    }
    setText(newText) {
        const oldText = this.el.innerText;
        const length = Math.max(oldText.length, newText.length);
        const promise = new Promise(resolve => this.resolve = resolve);
        this.queue = [];
        for (let i = 0; i < length; i++) {
            const from = oldText[i] || '';
            const to = newText[i] || '';
            const start = Math.floor(Math.random() * 40);
            const end = start + Math.floor(Math.random() * 40);
            this.queue.push({ from, to, start, end });
        }
        cancelAnimationFrame(this.frameRequest);
        this.frame = 0;
        this.update();
        return promise;
    }
    update() {
        let output = '';
        let complete = 0;
        for (let i = 0, n = this.queue.length; i < n; i++) {
            let { from, to, start, end, char } = this.queue[i];
            if (this.frame >= end) {
                complete++;
                output += to;
            } else if (this.frame >= start) {
                if (!char || Math.random() < 0.28) {
                    char = this.randomChar();
                    this.queue[i].char = char;
                }
                output += `<span class="dud">${char}</span>`;
            } else {
                output += from;
            }
        }
        this.el.innerHTML = output;
        if (complete === this.queue.length) {
            this.resolve();
        } else {
            this.frameRequest = requestAnimationFrame(this.update);
            this.frame++;
        }
    }
    randomChar() {
        return this.chars[Math.floor(Math.random() * this.chars.length)];
    }}

const phrases = [
    'Dounia Manhouli',
    '2021',
    ' © Tous droits réservés'];


const el = document.querySelector('.text');
const fx = new TextScramble(el);

let counter = 0;
const next = () => {
    fx.setText(phrases[counter]).then(() => {
        setTimeout(next, 800);
    });
    counter = (counter + 1) % phrases.length;
};

next();




/*Animations scroll de la nav*/
$(function() {
    /**
     * Smooth scrolling to page anchor on click
     **/
    $("a[href*='#']:not([href='#'])").click(function() {
        if (
            location.hostname == this.hostname
            && this.pathname.replace(/^\//,"") == location.pathname.replace(/^\//,"")
        ) {
            var anchor = $(this.hash);
            anchor = anchor.length ? anchor : $("[name=" + this.hash.slice(1) +"]");
            if ( anchor.length ) {
                $("html, body").animate( { scrollTop: anchor.offset().top }, 1500);
            }
        }
    });
});


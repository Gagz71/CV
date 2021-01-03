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


//Animations progress bar circulaire compétences
//Fonction permettant d'ouvrir la div
function openView(){

    //Suppression de l'ancien écouteur d'évènement
    $('.target').off();

    //Disparition du petit texte avec effet de fondu
    $('.target .tiny').fadeOut();

    //Animations de déplacement et d'aggrandissement de la div
    $('.target').animate({
        'top': window.innerHeight/4,  //window.innerHeight dans la console permet d'avoir la hauteur de la fenêtre active en px
        'left': window.innerWidth/4 //window.innerWidth   ""  la largeur ""
    }, 750).animate({
        'width': window.innerWidth/2,
        'height': 450
    }, 750, function(){

        //Apparition du grand texte avec effet fondu
        $('.target .normal').fadeIn();

        //Mise en place d'un écouteur d'évènement sur la cible permettant de la faire fermer au click
        $('.target').click(function(){

            //Fermeture de la div
            closeView();
        });
    });

}

//Fonction permettant de fermer la div
function closeView(){

    //Suppression de l'ancien écouteur d'évènement
    $('.target').off();

    //Disparition du grand texte
    $('.target .normal').hide();

    //Animations de rétrécissement et de déplacement de la div
    $('.target').animate({
        'width': '100px',
        'height': '50px'
    }, 750).animate({
        'top': '25px',
        'left': '25px'
    }, 750, function(){

        //Apparition du petit texte
        $('.tiny').fadeIn();

        $('.target').click(function(){
            openView();
        });
    });
}

$('.target').click(function(){
    openView();
});

//Animations compétences




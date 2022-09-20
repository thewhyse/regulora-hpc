const targetElement = '.image-anchor';
const containers = document.querySelectorAll( '.wp-block-cover' );

function ImageExplorer(img) {
    
    // Var
    let image;
    let canvas;
    let context;
    let selector;
    
    // Initialization
    const init = () => {
        
        image = getHTMLImageElement(img);
        
        // Создаем канвас для работы, получаем его контекст
        canvas = document.createElement('canvas');
        context = canvas.getContext('2d');
        
        // Проверяем переданный селектор, определяющий, подходит ли нам пиксель
        
            // Альфа-канал равен 0 => пиксель прозрачен
            selector = color => { return color[0] >= 250 && color[0] <= 255 && color[1] >= 0 && color[1] <= 5 && color[2] >= 0 && color[2] <= 5 };
    
        findRegions();
    }
    
    // Funcs
    
    // Ищем пустые регионы
    const findRegions = () => {
        // Ожидаем загрузки изображения
        new Promise(res => {
            let intervalID = setInterval(() => {
                if (image.complete)
                {
                    clearInterval(intervalID);
                    clearCanvas();
                    // Разрешаем текущее обещание
                    res();
                }
            }, 300);
        }).then(() => {
            // Отрисовываем картинку
            let imageComputedStyle = window.getComputedStyle(img);
            let imagePositions = imageComputedStyle.getPropertyValue('object-position').split(' ');
            let horizontalPercentage = parseInt(imagePositions[0]) / 100;
            let verticalPercentage = parseInt(imagePositions[1]) / 100;
            let origHeight = img.getAttribute( 'height' );
            let origWidth = img.getAttribute( 'width' );
    
            let naturalRatio = origWidth / origHeight;
            let visibleRatio = img.width / img.height;
    
            if (naturalRatio > visibleRatio)
            {
                origWidth = origWidth * visibleRatio;
            }
            else
            {
                origHeight = origHeight / visibleRatio;
            }
            
            let startX = 0;
            let startY = 0;
    
            startX = origWidth * horizontalPercentage;
            if ( ( startX + image.width / 2 ) > image.width ) {
                let diffX = ( startX + image.width / 2 ) - image.width;
                console.log('diffX = ' + diffX);
                startX = startX - diffX;
            }
    
            startY = origHeight * verticalPercentage;
            if ( ( startY + image.height / 2 ) > image.height ) {
                let diffY = ( startY + image.height / 2 ) - image.height;
                console.log('diffY = ' + diffY);
                startY = startY - diffY;
            }
            console.log('startX = ' + startX);
            console.log('startY = ' + startY);
            context.drawImage(image, startX, startY);
            // Получаем данные о ее пикселях
            let imgData = context.getImageData(0, 0, image.width, image.height).data;
            // console.log(imgData);
            // Функция, которая по значениям x и y вернет цвет указанного пикселя ([a, r, g, b])
            let getPixel = (dX, dY) => {
                let index = 4 * (dX + dY * image.width);
                return [imgData[index], imgData[index + 1], imgData[index + 2], imgData[index + 3]];
            };
            console.log(image.width);
            console.log(image.height);
            // Проходимся по каждому пикселю изображения
            for (let y = 0; y < image.height; y++)
                for (let x = 0; x < image.width; x++) {
                    // console.log(getPixel(x, y));
                    // selector(getPixel(x, y))
                    // return;
                        // Если пиксель подходит нам, начинаем обследование региона
                    if (selector(getPixel(x, y))) {
                        console.log('here');
                        console.log(getPixel(x, y));
                        console.log([x, y]);
                        // return [x, y];
                    }
                }
            
            return 'null';
        });
    };
    
    // Загружаем изображение
    const getHTMLImageElement = (data) => {
        let result;
        if ((typeof data) == 'string') {
            result = new Image();
            // Передана ссылка/Base64-строка
            result.src = data;
        }
        else
        if (data instanceof HTMLImageElement)
            // Передан элемент <img>
            result = data;
        else
        if (data[0] instanceof HTMLImageElement)
            // Передан элемент <img>, бережно укутанный селектором jQuery
            result = data[0];
        else
            throw 'Необходимо передать изображение!'
        return result;
    }
    
    // Растягиваем канвас до размеров изображения и чистим его
    const clearCanvas = () => {
        canvas.width = image.width;
        canvas.height = image.height;
        context.clearRect(0, 0, canvas.width, canvas.height);
    }
    
    init();
}

const getRenderedSize = (contains, cWidth, cHeight, width, height, pos) => {
    let oRatio = width / height,
        cRatio = cWidth / cHeight;
    return function() {
        if (contains ? (oRatio > cRatio) : (oRatio < cRatio)) {
            this.width = cWidth;
            this.height = cWidth / oRatio;
        } else {
            this.width = cHeight * oRatio;
            this.height = cHeight;
        }
        this.left = (cWidth - this.width)*(pos/100);
        this.right = this.width + this.left;
    
        this.top = (cHeight - this.height)*(pos/100);
        this.bottom = this.top + this.height;
    
        return this;
    }.call({});
}

const getImgSizeInfo = (img) => {
    let pos = window.getComputedStyle(img).getPropertyValue('object-position').split(' ');
    return getRenderedSize(true,
        img.width,
        img.height,
        img.naturalWidth,
        img.naturalHeight,
        parseInt(pos[0]));
}

const getObjectFitSize = (contains /* true = contain, false = cover */, containerWidth, containerHeight, width, height) => {
    let doRatio = width / height;
    let cRatio = containerWidth / containerHeight;
    let targetWidth = 0;
    let targetHeight = 0;
    let test = contains ? (doRatio > cRatio) : (doRatio < cRatio);
    
    if (test) {
        targetWidth = containerWidth;
        targetHeight = targetWidth / doRatio;
    } else {
        targetHeight = containerHeight;
        targetWidth = targetHeight * doRatio;
    }
    
    return {
        width: targetWidth,
        height: targetHeight,
        x: (containerWidth - targetWidth) / 2,
        y: (containerHeight - targetHeight) / 2,
    };
}

const objectFitCalc = ( img ) => {
    let imageComputedStyle = window.getComputedStyle(img);
    let coordinates = {};
    coordinates.naturalWidth = img.naturalWidth;
    coordinates.naturalHeight = img.naturalHeight;
    let imagePositions = imageComputedStyle.getPropertyValue('object-position').split(' ');
    let horizontalPercentage = parseInt(imagePositions[0]) / 100;
    let verticalPercentage = parseInt(imagePositions[1]) / 100;
    let naturalRatio = img.naturalWidth / img.naturalHeight;
    let visibleRatio = img.width / img.height;
    let visibleHeightPercent = img.height * 100 / img.naturalHeight;
    let visibleWidthPercent = img.width * 100 / img.naturalWidth;
    
    if (naturalRatio > visibleRatio)
    {
        coordinates.sourceWidth = img.naturalHeight * visibleRatio;
        coordinates.sourceHeight = img.naturalHeight;
        coordinates.sourceX = (img.naturalWidth - coordinates.sourceWidth) * horizontalPercentage;
        coordinates.sourceY = 0;
    }
    else
    {
        coordinates.sourceWidth = img.naturalWidth;
        coordinates.sourceHeight = img.naturalWidth / visibleRatio;
        coordinates.sourceX = 0;
        coordinates.sourceY = (img.naturalHeight - coordinates.sourceHeight) * verticalPercentage;
        // coordinates.
    }
    coordinates.destinationWidthPercentage = 1;
    coordinates.destinationHeightPercentage = 1;
    coordinates.destinationXPercentage = 0;
    coordinates.destinationYPercentage = 0;
    coordinates.visibleHeightPercent = visibleHeightPercent;
    coordinates.visibleWidthPercent = visibleWidthPercent;
    coordinates.naturalRatio = naturalRatio;
    coordinates.visibleRatio = visibleRatio;
    
    coordinates.imgHeight = img.height;
    coordinates.imgWidth = img.width;
    
    return coordinates;
};

const construct = ( container ) => {
    let vars = {
        container : container,
        img : container.querySelector( '.wp-block-cover__image-background' ),
        targetElement : container.querySelector( targetElement ),
        positionBlock : container.querySelector( '.wp-block-cover__inner-container' ),
        focalPoint : { top: 0, left: 0 },
        imageSize : { width: 0, height: 0 },
        blockSize : { width: 0, height: 0 },
        dotCoords : { top: 0, left: 0 },
    };
    // const img = container.querySelector( '.wp-block-cover__image-background' );
    // const targetElement = container.querySelector( targetElement );
    // const positionBlock = container.querySelector( '.wp-block-cover__inner-container' );
    // const focalPoint = { top: 0, left: 0 };
    // const imageSize = { width: 0, height: 0 };
    // const blockSize = { width: 0, height: 0 };
    
    vars = assignVariables( vars );
    
    // dot coords
    vars.targetElement.classList.forEach( item => {
        console.log(item);
        if ( item.indexOf( 'pos-' ) >= 0 ) {
            let classItem = item.split( '-' );
            classItem.map( val => {
                if ( val.indexOf( 'l' ) >= 0 ) {
                    let pers = val.slice(1).replace( /_/g, '.' );
                    // pers = vars.imageSize.width * parseFloat( pers ) / 100;
                    vars.dotCoords.left = parseFloat( pers );
                }
                if ( val.indexOf( 't' ) >= 0 ) {
                    let pers = val.slice(1).replace( /_/g, '.' );
                    //pers = vars.imageSize.height * parseFloat( pers ) / 100;
                    vars.dotCoords.top = parseFloat( pers );
                }
            } );
            
        }
    } )
    
    let fragment = document.createDocumentFragment();
    fragment.appendChild( vars.targetElement );
    vars.container.appendChild(fragment);
    
    // test dot
    // const dot = document.createElement( 'div' );
    // dot.classList.add( 'dot-over' );
    // dot.style.backgroundColor = '#f00';
    // dot.style.width = '15px';
    // dot.style.height = '15px';
    // dot.style.position = 'absolute';
    // // dot.style.top = '53.333%';//focalPoint.top;
    // // dot.style.left = '32.552%';//focalPoint.left;
    // vars.container.appendChild( dot );
    
    vars.targetElement.style.position = 'absolute';
    vars.targetElement.classList.add( 'm-0' );
    
    console.log(vars.blockSize);
    console.log(vars.imageSize);
    console.log(vars.focalPoint);
    
    objectUpdate( vars.targetElement, vars );
    
    window.addEventListener( 'resize', function(){
        vars = assignVariables( vars );
        objectUpdate( vars.targetElement, vars );
        
        // console.log(objectFitCalc(vars.img));
        // console.log(getObjectFitSize(false, vars.blockSize.width, vars.blockSize.height, vars.imageSize.width, vars.imageSize.height));
    } )
    document.addEventListener( 'click', function(){
        // console.log(objectFitCalc(vars.img));
        let dotCoords = ImageExplorer(vars.img);
        console.log(dotCoords);
    } )
};

const assignVariables = ( vars ) => {
    // set block size
    vars.blockSize.width = vars.container.offsetWidth;
    vars.blockSize.height = vars.container.offsetHeight;
    
    // set image size
    vars.imageSize.width = vars.img.getAttribute( 'width' );
    vars.imageSize.height = vars.img.getAttribute( 'height' );
    
    // set focal point
    if ( 'objectPosition' in vars.img.dataset ) {
        let focal = vars.img.dataset.objectPosition;
        focal = focal.split( ' ' );
        vars.focalPoint.left = focal[ 0 ];
        vars.focalPoint.top = focal[ 1 ];
    }
    
    return vars;
};

const objectUpdate = ( object, vars ) => {
    //let objectFitSize = getObjectFitSize(false, vars.blockSize.width, vars.blockSize.height, vars.imageSize.width, vars.imageSize.height);
    let objectFitSize = objectFitCalc( vars.img );
    // object.style.top = ( ( objectFitSize.height * vars.dotCoords.top / 100 ) + objectFitSize.y ) + 'px';
    // object.style.left = ( ( objectFitSize.width * vars.dotCoords.left / 100 ) + objectFitSize.x ) + 'px';
    object.style.top = ( ( vars.imageSize.height * vars.dotCoords.top / 100 ) - ( objectFitSize.sourceY ) ) + 'px';
    object.style.left = ( ( vars.imageSize.width * vars.dotCoords.left / 100 ) - objectFitSize.sourceX ) + 'px';
};

const init = () => {
    if ( containers ) {
        containers.forEach( container => {
            if ( container.querySelector( targetElement ) )
                setTimeout( function(){construct( container )}, 600);
        } )
    }
};

export { init };
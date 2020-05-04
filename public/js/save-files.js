
class SaveFiles{
    //

    constructor(countFile, maxSizeFile, maxSizeAllFiles, elInputFiles, onSubmitBtn, form){
        this.countFile = this.str_number(countFile); // количество файлов
        this.maxSizeFile = this.str_number(maxSizeFile); // максимальный размер файла
        this.maxSizeAllFiles = this.str_number(maxSizeAllFiles); // общий размер всех файлов
        this.elInputFiles = elInputFiles; // элемент - выбор файлов
        this.onSubmitBtn = onSubmitBtn; // кнопка сохранение
        this.form = form; // форма
    }

    str_number(str){
        if(typeof str == "number") str;
        return parseInt(str, 10);
    }

    get_btn(){
        return this.onSubmitBtn;
    }

    init(){
        // привязка сабмита
        this.form.onsubmit = this.formSubmit.bind(this);
    }

    formSubmit(event){
        if(this.checkIsFiles()) { return true; }
        // проверка на количество файлов
        if(this.checkCountFiles()) { return false; };
        // проверка на размеры файлов
        if(this.checkSizeFiles()) { return false; }
        // проверка на общий размер файлов
        if(this.checkSumAllFile()) { return false; }
        // если все окей подтверждаем форму
        return true;


    }

    checkSumAllFile(){
        var total = 0;
        for(var l = 0; l < this.elInputFiles.files.length; l++ ){
            total += Number(this.sizeFile(this.elInputFiles.files.item(l), 9));
        }
        if(total > this.maxSizeAllFiles.toFixed(9)){
            this.noty(
                `Загальний розмір файлів ${total.toFixed(2)}Gb, перевищує допустиму норму ${this.maxSizeAllFiles}Gb`
            );
            return true;
        }else{
            return false;
        }
    }



    checkCountFiles(){
        var count_files = this.elInputFiles.files.length;
        if(count_files > this.countFile){
            this.noty(
                `Ви завантажили занадто багато файлів - ${count_files}, допустима кількість файлів - ${this.countFile}`
            );
            return true;
        }else{
            return false;
        }

    }

    checkSizeFiles(){
        var element_error = [];
        for (var i = 0; i < this.elInputFiles.files.length; i++) {
            var file = this.elInputFiles.files.item(i);
            //console.log(`file-name: ${file.name} \n size: ${(file.size / 1024 / 1024 / 1024).toFixed(5)}Gb`);
            if(this.checkSizeFile(file)){
                element_error.push(file);
            }
        }
        if(!element_error.length == 0){
            this.showErrorMessageSizeFiles(element_error);
            return true;
        }else{
            return false;
        }
    }

    checkIsFiles(){
        return this.elInputFiles.files.length == 0 ? true : false;
    }

    checkSizeFile(file){
        var size_file = (file.size / 1024 / 1024 / 1024).toFixed(9);
        if(size_file > this.maxSizeFile.toFixed(9)){
            return true;
        }else{
            return false;
        }
    }

    showErrorMessageSizeFiles(files){
        var strs_message = [];
        for(var i = 0; i < files.length; i++){
            strs_message.push(`Файл ${files[i].name} занадто великий - ${this.sizeFileStr(files[i])}`);
        }
        //console.log(strs_message);
        for(var j = 0; j < strs_message.length; j++){
            this.noty(strs_message[j])
        }
    }

    noty(message){
        new Noty({
            layout   : 'topRight',
            type: 'error',
            theme    : 'metroui',
            text: message
        }).show();
    }


    sizeFileStr(file){
        return `${this.sizeFile(file)}Gb`;
    }

    sizeFile(file, count_fix = 2){
        return (file.size / 1024 / 1024 / 1024).toFixed(count_fix);
    }
}

function maskCPF(numeroCPF) {
    var cpf = numeroCPF.value;

    if (isNaN(cpf[cpf.length - 1])) { // Proibir caractere que não seja número
        numberCPF.value = cpf.substring(0, cpf.length - 1);
        return;
    }

    if(cpf.length === 3 || cpf.length === 7){
        numberCPF.value += ".";
    }

    if(cpf.length === 11){
        numberCPF.value += "-";
    }

}

function maskCell(numeroCell){
    var cell = numeroCell.value;
    
    if(cell.length < 14){
        cell = cell.replace(/\D/g, "");
        cell = cell.replace(/^(\d{2})(\d)/g, "($1)$2");
        cell = cell.replace(/(\d)(\d{3})$/, "$1-$2");
        numeroCell.value = cell;
    }
}
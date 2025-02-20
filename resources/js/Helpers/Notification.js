import Noty from 'noty'; 
class Notification {
    success() { 
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: 'Successfully done !',
            timeout: 2000,
        }).show();
    }
    alert() { 
        new Noty({
            type: 'alert',
            layout: 'topRight',
            text: 'Are you sure ?',
            timeout: 2000,
        }).show();
    }
    error() { 
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: 'Something went wrong !',
            timeout: 2000,
        }).show();
    }

    warning() { 
        new Noty({
            type: 'warning',
            layout: 'topRight',
            text: 'Oops ! wrong',
            timeout: 2000,
        }).show();
    }
    image_validation(){
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: 'Upload image less than 1mb !',
            timeout: 2000,
        }).show();
    }
}
const notification = new Notification();
export default notification;
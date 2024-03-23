import { Calendar } from '@fullcalendar/core';
import adaptivePlugin from '@fullcalendar/adaptive';
import interactionPlugin from '@fullcalendar/interaction';
import dayGridPlugin from '@fullcalendar/daygrid';
import listPlugin from '@fullcalendar/list';
import timeGridPlugin from '@fullcalendar/timegrid';
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';

document.addEventListener('DOMContentLoaded', function() {
    window.Calendar = Calendar;

    window.adaptivePlugin = adaptivePlugin;
    window.interactionPlugin = interactionPlugin;
    window.dayGridPlugin = dayGridPlugin;
    window.listPlugin = listPlugin;
    window.timeGridPlugin = timeGridPlugin;
    window.resourceTimelinePlugin = resourceTimelinePlugin;

});

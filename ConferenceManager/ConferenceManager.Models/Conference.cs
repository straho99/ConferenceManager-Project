namespace ConferenceManager.Models
{
    using System;
    using System.Collections.Generic;
    using System.ComponentModel.DataAnnotations;

    public class Conference
    {
        private ICollection<Lecture> lectures;
        private ICollection<User> participants;

        public Conference()
        {
            this.lectures = new HashSet<Lecture>();
            this.participants = new HashSet<User>();
        }

        [Required]
        public int Id { get; set; }

        [Required]
        public string Name { get; set; }

        [Required]
        public DateTime StartDate { get; set; }

        [Required]
        public DateTime EndDate { get; set; }

        [Required]
        public int OwnerId { get; set; }

        public virtual User Owner { get; set; }

        [Required]
        public int VenueId { get; set; }

        public virtual Venue Venue { get; set; }

        public bool IsVenueConfirmed { get; set; }

        public virtual ICollection<Lecture> Lectures
        {
            get
            {
                return this.lectures;
            }

            set
            {
                this.lectures = value;
            }
        }

        public virtual ICollection<User> Participants
        {
            get
            {
                return this.participants;
            }

            set
            {
                this.participants = value;
            }
        }
    }
}

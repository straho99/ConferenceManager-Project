namespace ConferenceManager.Models
{
    using System;
    using System.Collections.Generic;
    using System.ComponentModel.DataAnnotations;

    public class Lecture
    {
        private ICollection<Break> breaks;
        private ICollection<User> participants;

        private ICollection<SpeakerInvitation> speakerInvitations;

        public Lecture()
        {
            this.breaks = new HashSet<Break>();
            this.participants = new HashSet<User>();

            this.speakerInvitations = new HashSet<SpeakerInvitation>();
        }

        [Key]
        public int Id { get; set; }

        [Required]
        public string Title { get; set; }

        public string Description { get; set; }

        [Required]
        public DateTime StartDate { get; set; }

        [Required]
        public DateTime EndDate { get; set; }

        [Required]
        public int LecturerId { get; set; }

        public virtual User Lecturer { get; set; }

        public int SpeakerId { get; set; }

        public virtual User Speaker { get; set; }

        public int HallId { get; set; }

        public virtual Hall Hall { get; set; }

        [Required]
        public int ConferenceId { get; set; }

        public virtual Conference Conference { get; set; }

        public virtual ICollection<Break> Breaks
        {
            get
            {
                return this.breaks;
            }

            set
            {
                this.breaks = value;
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

        public virtual ICollection<SpeakerInvitation> SpeakerInvitations
        {
            get
            {
                return this.speakerInvitations;
            }

            set
            {
                this.speakerInvitations = value;
            }
        }
    }
}

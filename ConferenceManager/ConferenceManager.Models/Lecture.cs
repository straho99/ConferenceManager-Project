namespace ConferenceManager.Models
{
    using System;
    using System.Collections.Generic;
    using System.ComponentModel.DataAnnotations;

    public class Lecture
    {
        private ICollection<Break> breaks;
        private ICollection<Break> participants;

        public Lecture()
        {
            this.breaks = new HashSet<Break>();
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

        public SpeakerInvitation Speaker { get; set; }

        [Required]
        public int HallId { get; set; }

        public virtual Hall Hall { get; set; }

        [Required]
        public int ConferenceId { get; set; }

        public virtual Conference Conference { get; set; }

        public ICollection<Break> Breaks
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
    }
}

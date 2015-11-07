namespace ConferenceManager.Models
{
    using System.ComponentModel.DataAnnotations;

    public class SpeakerInvitation
    {
        [Key]
        public int Id { get; set; }

        [Required]
        public int LectureId { get; set; }

        public Lecture Lecture { get; set; }

        [Required]
        public int SpeakerId { get; set; }

        public User Speaker { get; set; }

        [Required]
        public RequestStatus Status { get; set; }
    }
}
